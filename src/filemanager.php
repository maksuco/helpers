<?php

declare(strict_types=1);

/**
 * Standalone file manager. Copy this one file into a site. No Composer, no framework.
 *
 * The password is not stored here. Put it in that site's .env (one password per site):
 *
 *   FILEMANAGER_PASSWORD=change-this-to-a-long-secret
 *   # Optional. Defaults to the folder that contains the .env file.
 *   # FILEMANAGER_ROOT=/home/account/public_html
 *
 * This file walks upward from its own folder and uses the nearest .env that sets
 * FILEMANAGER_PASSWORD. A parent folder cannot widen the root past that file.
 * If the host already injects FILEMANAGER_PASSWORD, that is used when no .env has it.
 *
 * PHP 8.4 or newer.
 */

const FM_MIN_PASSWORD = 12;
const FM_LIST_LIMIT = 2000;
const FM_LOCK_AFTER = 8;
const FM_LOCK_SECONDS = 300;

function fm_e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function fm_is_absolute(string $path): bool
{
    if ($path === '') {
        return false;
    }
    if ($path[0] === '/' || $path[0] === '\\') {
        return true;
    }

    return (bool) preg_match('/^[A-Za-z]:[\\\\\\/]/', $path);
}

function fm_inside(string $root, string $path): bool
{
    $root = rtrim(str_replace('\\', '/', $root), '/');
    $path = rtrim(str_replace('\\', '/', $path), '/');
    if (PHP_OS_FAMILY === 'Windows') {
        $root = strtolower($root);
        $path = strtolower($path);
    }
    if ($root === '') {
        return false;
    }

    return $path === $root || str_starts_with($path, $root . '/');
}

function fm_is_broad_root(string $root): bool
{
    $normalized = rtrim(str_replace('\\', '/', $root), '/');
    if ($normalized === '') {
        return true;
    }

    return PHP_OS_FAMILY === 'Windows' && (bool) preg_match('/^[A-Za-z]:$/', $normalized);
}

function fm_parts(string $rel): ?array
{
    $rel = str_replace('\\', '/', $rel);
    $rel = trim($rel, '/');
    if ($rel === '') {
        return [];
    }
    if (str_contains($rel, "\0")) {
        return null;
    }
    $parts = [];
    foreach (explode('/', $rel) as $part) {
        if ($part === '' || $part === '.' || $part === '..') {
            return null;
        }
        $parts[] = $part;
    }

    return $parts;
}

function fm_safe_name(string $name): ?string
{
    $name = str_replace("\0", '', $name);
    $name = basename(str_replace('\\', '/', $name));
    if ($name === '' || $name === '.' || $name === '..' || trim($name) === '') {
        return null;
    }
    if (strlen($name) > 180) {
        return null;
    }

    return $name;
}

function fm_unquote_env(string $value): string
{
    if ($value === '') {
        return '';
    }
    $quote = $value[0];
    if (($quote === '"' || $quote === "'") && str_ends_with($value, $quote) && strlen($value) >= 2) {
        $inner = substr($value, 1, -1);
        if ($quote === '"') {
            $inner = str_replace(['\\n', '\\r', '\\t', '\\"', '\\\\'], ["\n", "\r", "\t", '"', '\\'], $inner);
        }

        return $inner;
    }
    $hash = strpos($value, ' #');
    if ($hash !== false) {
        $value = trim(substr($value, 0, $hash));
    }

    return $value;
}

function fm_parse_env_keys(string $file): array
{
    $lines = @file($file, FILE_IGNORE_NEW_LINES);
    if (!is_array($lines)) {
        return [];
    }
    $found = [];
    foreach ($lines as $index => $line) {
        if ($index === 0) {
            $line = preg_replace('/^\xEF\xBB\xBF/', '', $line) ?? $line;
        }
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#')) {
            continue;
        }
        if (str_starts_with($line, 'export ')) {
            $line = trim(substr($line, 7));
        }
        $eq = strpos($line, '=');
        if ($eq === false) {
            continue;
        }
        $key = trim(substr($line, 0, $eq));
        if ($key !== 'FILEMANAGER_PASSWORD' && $key !== 'FILEMANAGER_ROOT') {
            continue;
        }
        $found[$key] = fm_unquote_env(trim(substr($line, $eq + 1)));
    }

    return $found;
}

function fm_env_files(string $start): array
{
    $files = [];
    $dir = $start;
    for ($i = 0; $i < 8; $i++) {
        $candidate = $dir . DIRECTORY_SEPARATOR . '.env';
        if (is_file($candidate) && is_readable($candidate)) {
            $files[] = $candidate;
        }
        $parent = dirname($dir);
        if ($parent === $dir) {
            break;
        }
        $dir = $parent;
    }

    return $files;
}

function fm_resolve_root(string $setting, string $base): ?string
{
    if ($setting === '') {
        $setting = $base;
    }
    if (!fm_is_absolute($setting)) {
        $setting = rtrim($base, '/\\') . DIRECTORY_SEPARATOR . $setting;
    }
    $real = realpath($setting);
    if ($real === false || !is_dir($real) || !is_readable($real)) {
        return null;
    }

    return $real;
}

function fm_config(string $start, bool $serverEnv = true): array
{
    $password = '';
    $passwordFile = '';
    $rootSetting = '';
    $rootBase = $start;

    foreach (fm_env_files($start) as $file) {
        $keys = fm_parse_env_keys($file);
        if ($rootSetting === '' && ($keys['FILEMANAGER_ROOT'] ?? '') !== '') {
            $rootSetting = $keys['FILEMANAGER_ROOT'];
            $rootBase = dirname($file);
        }
        if (($keys['FILEMANAGER_PASSWORD'] ?? '') !== '') {
            $password = $keys['FILEMANAGER_PASSWORD'];
            $passwordFile = $file;
            break;
        }
    }

    if ($password === '' && $serverEnv) {
        $fromEnv = getenv('FILEMANAGER_PASSWORD');
        if (is_string($fromEnv) && $fromEnv !== '') {
            $password = $fromEnv;
        }
        if ($rootSetting === '') {
            $fromRoot = getenv('FILEMANAGER_ROOT');
            if (is_string($fromRoot) && $fromRoot !== '') {
                $rootSetting = $fromRoot;
                $rootBase = $start;
            }
        }
    }

    $fail = static function (string $error) use ($passwordFile): array {
        return [
            'ok' => false,
            'error' => $error,
            'password' => '',
            'root' => '',
            'env_file' => $passwordFile,
            'self' => realpath(__FILE__) ?: '',
        ];
    };

    if ($password === '') {
        return $fail('missing_password');
    }
    if (strlen($password) < FM_MIN_PASSWORD) {
        return $fail('short_password');
    }

    $root = fm_resolve_root($rootSetting, $passwordFile !== '' ? dirname($passwordFile) : $rootBase);
    if ($root === null) {
        return $fail('bad_root');
    }
    if (fm_is_broad_root($root)) {
        return $fail('broad_root');
    }

    $envFile = $passwordFile !== '' ? (realpath($passwordFile) ?: $passwordFile) : '';

    return [
        'ok' => true,
        'error' => '',
        'password' => $password,
        'root' => $root,
        'env_file' => $envFile,
        'self' => realpath(__FILE__) ?: '',
    ];
}

function fm_password_ok(string $stored, string $given): bool
{
    if ($stored === '' || $given === '') {
        return false;
    }
    $info = password_get_info($stored);
    if (($info['algo'] ?? 0) !== 0) {
        return password_verify($given, $stored);
    }

    return hash_equals($stored, $given);
}

function fm_auth_token(string $password, string $root): string
{
    return hash('sha256', $password . "\0" . $root);
}

function fm_open(string $root, string $rel): ?array
{
    $parts = fm_parts($rel);
    if ($parts === null) {
        return null;
    }
    $abs = $root;
    foreach ($parts as $part) {
        $candidate = $abs . DIRECTORY_SEPARATOR . $part;
        $real = realpath($candidate);
        if ($real === false || !is_dir($real) || !fm_inside($root, $real)) {
            return null;
        }
        $abs = $real;
    }

    return ['abs' => $abs, 'rel' => implode('/', $parts), 'parts' => $parts];
}

function fm_target(string $root, string $rel): ?string
{
    $parts = fm_parts($rel);
    if ($parts === null || $parts === []) {
        return null;
    }
    $current = $root;
    $last = count($parts) - 1;
    foreach ($parts as $index => $part) {
        $candidate = $current . DIRECTORY_SEPARATOR . $part;
        $isLast = $index === $last;
        if (is_link($candidate)) {
            if ($isLast) {
                $parent = realpath($current);
                if ($parent === false || !fm_inside($root, $parent)) {
                    return null;
                }

                return $candidate;
            }
            $real = realpath($candidate);
            if ($real === false || !is_dir($real) || !fm_inside($root, $real)) {
                return null;
            }
            $current = $real;
            continue;
        }
        if ($isLast) {
            if (!file_exists($candidate)) {
                return null;
            }
            $real = realpath($candidate);
            if ($real === false || !fm_inside($root, $real)) {
                return null;
            }

            return $candidate;
        }
        $real = realpath($candidate);
        if ($real === false || !is_dir($real) || !fm_inside($root, $real)) {
            return null;
        }
        $current = $real;
    }

    return null;
}

function fm_name_blocked(string $dir, string $name, string $envFile, string $self): bool
{
    $dirReal = realpath($dir);
    if ($dirReal === false) {
        return true;
    }
    foreach ([$envFile, $self] as $blocked) {
        if ($blocked === '') {
            continue;
        }
        if ($dirReal === dirname($blocked) && $name === basename($blocked)) {
            return true;
        }
    }

    return false;
}

function fm_protected(string $path, string $root, string $envFile, string $self): bool
{
    if (is_link($path)) {
        return false;
    }
    $real = realpath($path);
    if ($real === false) {
        return false;
    }

    return $real === $root || ($envFile !== '' && $real === $envFile) || ($self !== '' && $real === $self);
}

function fm_delete_path(string $path, string $root, string $envFile, string $self): void
{
    if (is_link($path)) {
        $parent = realpath(dirname($path));
        if ($parent === false || !fm_inside($root, $parent)) {
            throw new RuntimeException('failed');
        }
        if (!@unlink($path)) {
            throw new RuntimeException('failed');
        }

        return;
    }

    $real = realpath($path);
    if ($real === false || !fm_inside($root, $real)) {
        throw new RuntimeException('failed');
    }
    if ($real === $root || ($envFile !== '' && $real === $envFile) || ($self !== '' && $real === $self)) {
        throw new RuntimeException('protected');
    }
    if (is_dir($real)) {
        if (fm_has_protected($real, $root, $envFile, $self)) {
            throw new RuntimeException('protected');
        }
        $items = @scandir($real, SCANDIR_SORT_NONE);
        if (!is_array($items)) {
            throw new RuntimeException('failed');
        }
        foreach ($items as $item) {
            if ($item === '.' || $item === '..') {
                continue;
            }
            fm_delete_path($real . DIRECTORY_SEPARATOR . $item, $root, $envFile, $self);
        }
        if (!@rmdir($real)) {
            throw new RuntimeException('failed');
        }

        return;
    }
    if (!@unlink($real)) {
        throw new RuntimeException('failed');
    }
}

function fm_has_protected(string $path, string $root, string $envFile, string $self): bool
{
    if (is_link($path)) {
        return false;
    }
    if (fm_protected($path, $root, $envFile, $self)) {
        return true;
    }
    if (!is_dir($path)) {
        return false;
    }
    $items = @scandir($path, SCANDIR_SORT_NONE);
    if (!is_array($items)) {
        return false;
    }
    foreach ($items as $item) {
        if ($item === '.' || $item === '..') {
            continue;
        }
        if (fm_has_protected($path . DIRECTORY_SEPARATOR . $item, $root, $envFile, $self)) {
            return true;
        }
    }

    return false;
}

function fm_dir_names(string $root, string $abs): array
{
    $items = @scandir($abs, SCANDIR_SORT_NONE);
    if (!is_array($items)) {
        return ['names' => [], 'truncated' => false, 'unreadable' => true];
    }
    $names = [];
    foreach ($items as $name) {
        if ($name === '.' || $name === '..') {
            continue;
        }
        $path = $abs . DIRECTORY_SEPARATOR . $name;
        if (!is_dir($path)) {
            continue;
        }
        if (is_link($path)) {
            $real = realpath($path);
            if ($real === false || !fm_inside($root, $real)) {
                continue;
            }
        }
        $names[] = $name;
    }
    sort($names, SORT_NATURAL | SORT_FLAG_CASE);
    $truncated = count($names) > FM_LIST_LIMIT;
    if ($truncated) {
        $names = array_slice($names, 0, FM_LIST_LIMIT);
    }

    return ['names' => $names, 'truncated' => $truncated, 'unreadable' => false];
}

function fm_list(string $abs): array
{
    $items = @scandir($abs, SCANDIR_SORT_NONE);
    if (!is_array($items)) {
        return ['rows' => [], 'truncated' => false, 'unreadable' => true];
    }
    $names = [];
    foreach ($items as $name) {
        if ($name === '.' || $name === '..') {
            continue;
        }
        $names[] = $name;
    }
    sort($names, SORT_NATURAL | SORT_FLAG_CASE);
    $truncated = count($names) > FM_LIST_LIMIT;
    if ($truncated) {
        $names = array_slice($names, 0, FM_LIST_LIMIT);
    }
    $rows = [];
    foreach ($names as $name) {
        $path = $abs . DIRECTORY_SEPARATOR . $name;
        $link = is_link($path);
        $dir = is_dir($path);
        $mtime = @filemtime($path);
        $size = $dir ? 0 : @filesize($path);
        $perms = @fileperms($path);
        $rows[] = [
            'name' => $name,
            'path' => $path,
            'dir' => $dir,
            'link' => $link,
            'mtime' => $mtime === false ? 0 : $mtime,
            'size' => $size === false ? 0 : $size,
            'perms' => $perms === false ? '' : substr(sprintf('%o', $perms), -4),
        ];
    }
    usort($rows, static function (array $a, array $b): int {
        if ($a['dir'] !== $b['dir']) {
            return $a['dir'] ? -1 : 1;
        }

        return strnatcasecmp($a['name'], $b['name']);
    });

    return ['rows' => $rows, 'truncated' => $truncated, 'unreadable' => false];
}

function fm_bytes(int $bytes): string
{
    if ($bytes < 1024) {
        return $bytes . ' B';
    }
    $value = $bytes / 1024;
    foreach (['KB', 'MB', 'GB', 'TB'] as $unit) {
        if ($value < 1024 || $unit === 'TB') {
            $places = $value >= 10 ? 0 : 1;

            return number_format($value, $places) . ' ' . $unit;
        }
        $value /= 1024;
    }

    return $bytes . ' B';
}

function fm_ini_bytes(string $value): int
{
    $value = trim($value);
    if ($value === '') {
        return 0;
    }
    $unit = strtolower($value[strlen($value) - 1]);
    $number = (float) $value;

    return match ($unit) {
        'g' => (int) ($number * 1024 * 1024 * 1024),
        'm' => (int) ($number * 1024 * 1024),
        'k' => (int) ($number * 1024),
        default => (int) $number,
    };
}

function fm_request_too_large(): bool
{
    if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
        return false;
    }
    $max = fm_ini_bytes((string) ini_get('post_max_size'));
    $length = (int) ($_SERVER['CONTENT_LENGTH'] ?? 0);

    return $max > 0 && $length > $max && $_POST === [] && $_FILES === [];
}

function fm_upload_error(int $code): string
{
    return match ($code) {
        UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE => 'is larger than the server allows',
        UPLOAD_ERR_PARTIAL => 'was interrupted',
        UPLOAD_ERR_NO_FILE => 'was empty',
        UPLOAD_ERR_NO_TMP_DIR => 'could not be stored (no temp folder)',
        UPLOAD_ERR_CANT_WRITE => 'could not be written',
        UPLOAD_ERR_EXTENSION => 'was blocked by the server',
        default => 'failed',
    };
}

function fm_uploaded_list(): array
{
    if (!isset($_FILES['files']) || !is_array($_FILES['files'])) {
        return [];
    }
    $bag = $_FILES['files'];
    if (!is_array($bag['name'] ?? null)) {
        return [[
            'name' => (string) ($bag['name'] ?? ''),
            'tmp' => (string) ($bag['tmp_name'] ?? ''),
            'error' => (int) ($bag['error'] ?? UPLOAD_ERR_NO_FILE),
        ]];
    }
    $list = [];
    foreach ($bag['name'] as $index => $name) {
        $list[] = [
            'name' => (string) $name,
            'tmp' => (string) ($bag['tmp_name'][$index] ?? ''),
            'error' => (int) ($bag['error'][$index] ?? UPLOAD_ERR_NO_FILE),
        ];
    }

    return $list;
}

function fm_throttle_file(): string
{
    $ip = (string) ($_SERVER['REMOTE_ADDR'] ?? 'local');

    return sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'fm-' . hash('sha256', $ip . '|' . __FILE__);
}

function fm_throttle(string $event): bool
{
    $path = fm_throttle_file();
    $handle = @fopen($path, 'c+');
    if ($handle === false) {
        return true;
    }
    try {
        if (!flock($handle, LOCK_EX)) {
            return true;
        }
        $raw = stream_get_contents($handle);
        $bits = explode(' ', trim((string) $raw));
        $fails = (int) ($bits[0] ?? 0);
        $until = (int) ($bits[1] ?? 0);
        $now = time();
        if ($until > 0 && $until <= $now) {
            $fails = 0;
            $until = 0;
        }
        if ($event === 'check') {
            return $until <= $now;
        }
        if ($event === 'reset') {
            $fails = 0;
            $until = 0;
        } elseif ($event === 'fail') {
            if ($until > $now) {
                return false;
            }
            $fails++;
            if ($fails >= FM_LOCK_AFTER) {
                $fails = 0;
                $until = $now + FM_LOCK_SECONDS;
            }
        }
        ftruncate($handle, 0);
        rewind($handle);
        fwrite($handle, $fails . ' ' . $until);
        fflush($handle);
        @chmod($path, 0600);

        return $until <= $now;
    } finally {
        flock($handle, LOCK_UN);
        fclose($handle);
    }
}

function fm_is_https(): bool
{
    if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
        return true;
    }
    if ((string) ($_SERVER['SERVER_PORT'] ?? '') === '443') {
        return true;
    }

    return strtolower((string) ($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '')) === 'https';
}

function fm_session(): void
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        return;
    }
    $script = str_replace('\\', '/', (string) ($_SERVER['SCRIPT_NAME'] ?? '/filemanager.php'));
    $cookiePath = rtrim(str_replace('\\', '/', dirname($script)), '/');
    if ($cookiePath === '' || $cookiePath === '.') {
        $cookiePath = '/';
    }
    ini_set('session.use_strict_mode', '1');
    ini_set('session.use_only_cookies', '1');
    session_name('helpers_files');
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => $cookiePath,
        'secure' => fm_is_https(),
        'httponly' => true,
        'samesite' => 'Strict',
    ]);
    session_start();
}

function fm_csrf(): string
{
    $token = $_SESSION['fm_csrf'] ?? '';
    if (!is_string($token) || $token === '') {
        $token = bin2hex(random_bytes(32));
        $_SESSION['fm_csrf'] = $token;
    }

    return $token;
}

function fm_csrf_ok(): bool
{
    $sent = $_POST['csrf'] ?? '';
    $have = $_SESSION['fm_csrf'] ?? '';

    return is_string($sent) && is_string($have) && $have !== '' && hash_equals($have, $sent);
}

function fm_authed(array $config): bool
{
    $token = $_SESSION['fm_auth'] ?? '';

    return is_string($token) && $token !== '' && hash_equals(fm_auth_token($config['password'], $config['root']), $token);
}

function fm_script_name(): string
{
    $script = str_replace('\\', '/', (string) ($_SERVER['SCRIPT_NAME'] ?? '/' . basename(__FILE__)));
    if ($script === '' || $script[0] !== '/') {
        $script = '/' . ltrim($script, '/');
    }

    return $script;
}

function fm_url(string $rel = '', array $extra = []): string
{
    $query = [];
    if ($rel !== '') {
        $query['dir'] = $rel;
    }
    foreach ($extra as $key => $value) {
        $query[$key] = $value;
    }

    return fm_script_name() . ($query === [] ? '' : '?' . http_build_query($query, '', '&', PHP_QUERY_RFC3986));
}

function fm_redirect(string $rel, ?string $message = null, string $type = 'ok'): never
{
    if ($message !== null) {
        $_SESSION['fm_flash'] = ['type' => $type, 'text' => $message];
    }
    header('Location: ' . fm_url($rel), true, 303);
    exit;
}

function fm_redirect_open(string $root, string $rel, ?string $message = null, string $type = 'ok'): never
{
    $opened = fm_open($root, $rel);
    fm_redirect($opened['rel'] ?? '', $message, $type);
}

function fm_security_headers(): void
{
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: DENY');
    header('Referrer-Policy: same-origin');
    header('Cache-Control: no-store, private');
}

function fm_icon(string $name): string
{
    $paths = [
        'folder' => '<path d="M3.5 7.75A1.75 1.75 0 0 1 5.25 6h4.1l1.4 1.5h7.75A1.75 1.75 0 0 1 20.25 9.25v8A1.75 1.75 0 0 1 18.5 19h-13A1.75 1.75 0 0 1 3.75 17.25v-9.5Z"/>',
        'file' => '<path d="M7 3.75h6.2L19 9.4V20.25H7V3.75Z"/><path d="M13 3.9V9.4h5.4"/>',
        'image' => '<path d="M4.75 6.75h14.5v10.5H4.75V6.75Z"/><path d="m7 14.5 2.4-2.4 2.1 2.1 2.2-2.6L17 14.5"/><path d="M9 9.2h.01"/>',
        'code' => '<path d="m9 8-3.5 4L9 16"/><path d="m15 8 3.5 4-3.5 4"/>',
        'archive' => '<path d="M5 4.75h14v14.5H5V4.75Z"/><path d="M12 4.75v14.5"/><path d="M10.2 8h1.6M12.2 10.5h1.6M10.2 13h1.6"/>',
        'up' => '<path d="M12 19V6"/><path d="m6.5 11 5.5-5.5L17.5 11"/>',
        'lock' => '<rect x="5" y="10" width="14" height="9" rx="1.5"/><path d="M8 10V7.5a4 4 0 0 1 8 0V10"/>',
    ];
    $body = $paths[$name] ?? $paths['file'];

    return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" class="size-4 shrink-0" aria-hidden="true">' . $body . '</svg>';
}

function fm_file_icon(string $name): string
{
    $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));

    return match (true) {
        in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'avif', 'ico'], true) => 'image',
        in_array($ext, ['zip', 'gz', 'tgz', 'rar', '7z', 'tar'], true) => 'archive',
        in_array($ext, ['php', 'phtml', 'js', 'mjs', 'css', 'scss', 'html', 'htm', 'json', 'xml', 'md', 'ts'], true) => 'code',
        default => 'file',
    };
}

function fm_fields(string $csrf, string $action, string $rel): string
{
    return '<input type="hidden" name="csrf" value="' . fm_e($csrf) . '">'
        . '<input type="hidden" name="action" value="' . fm_e($action) . '">'
        . '<input type="hidden" name="dir" value="' . fm_e($rel) . '">';
}

function fm_head(string $title): void
{
    fm_security_headers();
    header('Content-Type: text/html; charset=UTF-8');
    echo '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8">';
    echo '<meta name="viewport" content="width=device-width, initial-scale=1">';
    echo '<meta name="robots" content="noindex, nofollow">';
    echo '<title>' . fm_e($title) . '</title>';
    echo '<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>';
    echo '<style type="text/tailwindcss">@theme {';
    echo '--font-sans: "Avenir Next", "Segoe UI", "Helvetica Neue", sans-serif;';
    echo '--font-mono: "SFMono-Regular", "ui-monospace", "Cascadia Code", monospace;';
    echo '--color-ink: #161815;';
    echo '--color-paper: #f3f1eb;';
    echo '--color-line: #e3dfd4;';
    echo '--color-pine: #1a6b5c;';
    echo '--color-pine-dark: #124e43;';
    echo '}</style></head>';
}

function fm_setup_note(string $error): string
{
    return match ($error) {
        'short_password' => 'FILEMANAGER_PASSWORD must be at least 12 characters.',
        'bad_root' => 'FILEMANAGER_ROOT is not a folder this PHP process can read.',
        'broad_root' => 'FILEMANAGER_ROOT cannot be the root of the server. Point it at the site or the account folder.',
        default => '',
    };
}

function fm_render_setup(string $error): void
{
    $note = fm_setup_note($error);
    http_response_code(503);
    fm_head('Password required');
    echo '<body class="min-h-dvh bg-paper text-ink antialiased">';
    echo '<main class="mx-auto flex min-h-dvh w-full max-w-xl flex-col justify-center px-6 py-16">';
    echo '<p class="text-sm font-semibold tracking-wide text-pine">Files</p>';
    echo '<h1 class="mt-3 text-3xl font-semibold tracking-tight">Add a password for this site</h1>';
    echo '<p class="mt-3 text-[15px] leading-6 text-stone-600">This file does not keep a password. Add one to the <span class="font-medium text-ink">.env</span> of the site you copied it into. Each site has its own file, so each site has its own password.</p>';
    if ($note !== '') {
        echo '<p class="mt-5 rounded-xl border border-rose-200 bg-rose-50 px-3 py-2 text-sm text-rose-900">' . fm_e($note) . '</p>';
    }
    echo '<pre class="mt-6 overflow-auto rounded-2xl bg-ink px-4 py-4 text-[13px] leading-6 text-stone-100"><code>FILEMANAGER_PASSWORD=change-this-to-a-long-secret' . "\n";
    echo '# Optional. Defaults to the folder that contains this .env' . "\n";
    echo '# FILEMANAGER_ROOT=/home/account/public_html</code></pre>';
    echo '<p class="mt-4 text-sm leading-6 text-stone-500">Put <span class="font-medium text-stone-700">.env</span> in the same folder as <span class="font-medium text-stone-700">filemanager.php</span>, or in a parent folder. Keep it outside the public web folder when you can.</p>';
    echo '</main></body></html>';
}

function fm_render_login(?string $error): void
{
    $csrf = fm_csrf();
    http_response_code($error === null ? 200 : 401);
    fm_head('Sign in');
    echo '<body class="min-h-dvh bg-paper text-ink antialiased">';
    echo '<div class="grid min-h-dvh lg:grid-cols-2">';
    echo '<section class="hidden flex-col justify-between bg-ink px-12 py-12 text-paper lg:flex">';
    echo '<div class="flex items-center gap-2 text-sm font-semibold tracking-wide">' . fm_icon('folder') . '<span>Files</span></div>';
    echo '<div><p class="max-w-sm text-4xl font-semibold tracking-tight text-white">Upload and remove files on this site.</p>';
    echo '<p class="mt-4 max-w-sm text-sm leading-6 text-stone-400">The password is read from this site’s .env. It is not stored in the PHP file.</p></div>';
    echo '<p class="text-sm text-stone-500">One password per site.</p></section>';
    echo '<main class="flex items-center justify-center px-6 py-16">';
    echo '<form method="post" action="' . fm_e(fm_url()) . '" class="w-full max-w-sm">';
    echo '<div class="mb-8 flex items-center gap-2 text-sm font-semibold text-pine lg:hidden">' . fm_icon('folder') . '<span>Files</span></div>';
    echo '<h1 class="text-2xl font-semibold tracking-tight">Sign in</h1>';
    echo '<p class="mt-2 text-sm text-stone-500">Use the password from this site’s .env file.</p>';
    if ($error !== null) {
        echo '<p class="mt-4 rounded-xl border border-rose-200 bg-rose-50 px-3 py-2 text-sm text-rose-900" role="alert">' . fm_e($error) . '</p>';
    }
    echo '<input type="hidden" name="csrf" value="' . fm_e($csrf) . '">';
    echo '<input type="hidden" name="action" value="login">';
    echo '<label class="mt-6 block text-sm font-medium" for="password">Password</label>';
    echo '<input id="password" name="password" type="password" required autocomplete="current-password" autofocus class="mt-2 h-11 w-full rounded-xl border border-line bg-white px-3 text-sm outline-none ring-pine/20 focus:border-pine focus:ring-4">';
    echo '<button type="submit" class="mt-4 h-11 w-full rounded-xl bg-pine text-sm font-semibold text-white transition hover:bg-pine-dark">Continue</button>';
    echo '</form></main></div></body></html>';
}

function fm_tree(string $root, array $current): string
{
    $homeClass = $current === []
        ? 'bg-white/10 text-white'
        : 'text-stone-300 hover:bg-white/5 hover:text-white';
    $html = '<a href="' . fm_e(fm_url()) . '" class="flex items-center gap-2 rounded-lg px-2 py-1.5 text-sm ' . $homeClass . '">';
    $html .= fm_icon('folder') . '<span class="truncate">' . fm_e(basename($root)) . '</span></a>';
    $html .= fm_tree_level($root, [], $current);

    return $html;
}

function fm_tree_level(string $root, array $at, array $current): string
{
    $opened = fm_open($root, implode('/', $at));
    if ($opened === null) {
        return '';
    }
    $dirs = fm_dir_names($root, $opened['abs']);
    if ($dirs['names'] === []) {
        return '';
    }
    $nested = $at !== [];
    $html = '<ul class="' . ($nested ? 'mt-0.5 space-y-0.5 border-l border-white/10 pl-2 ml-3' : 'mt-1 space-y-0.5') . '">';
    foreach ($dirs['names'] as $name) {
        $child = array_merge($at, [$name]);
        $rel = implode('/', $child);
        $active = $current === $child;
        $open = array_slice($current, 0, count($child)) === $child;
        $class = $active
            ? 'bg-white/10 text-white'
            : 'text-stone-300 hover:bg-white/5 hover:text-white';
        $html .= '<li><a href="' . fm_e(fm_url($rel)) . '" class="flex items-center gap-2 rounded-lg px-2 py-1.5 text-sm ' . $class . '"';
        if ($active) {
            $html .= ' aria-current="page"';
        }
        $html .= ' title="' . fm_e($name) . '">' . fm_icon('folder') . '<span class="truncate">' . fm_e($name) . '</span></a>';
        if ($open) {
            $html .= fm_tree_level($root, $child, $current);
        }
        $html .= '</li>';
    }
    $html .= '</ul>';

    return $html;
}

function fm_env_is_public(string $envFile): bool
{
    if ($envFile === '') {
        return false;
    }
    $doc = realpath((string) ($_SERVER['DOCUMENT_ROOT'] ?? ''));
    $env = realpath($envFile);
    if ($doc === false || $env === false) {
        return false;
    }

    return fm_inside($doc, $env);
}

function fm_script(): string
{
    return <<<'JS'
<script>
document.addEventListener('submit', (event) => {
  const form = event.target;
  if (!(form instanceof HTMLFormElement)) return;
  const message = form.dataset.confirm;
  if (message && !window.confirm(message)) event.preventDefault();
});
const filter = document.querySelector('#filter');
if (filter) {
  filter.addEventListener('input', () => {
    const query = filter.value.trim().toLowerCase();
    document.querySelectorAll('[data-name]').forEach((row) => {
      const name = (row.getAttribute('data-name') || '').toLowerCase();
      row.hidden = query !== '' && !name.includes(query);
    });
  });
}
const input = document.querySelector('#files');
const picked = document.querySelector('#picked');
const drop = document.querySelector('#drop');
if (input && picked && drop) {
  const show = () => {
    const names = [...input.files].map((file) => file.name);
    picked.textContent = names.length ? names.join(', ') : 'Drop files here, or browse.';
  };
  input.addEventListener('change', show);
  ['dragenter', 'dragover'].forEach((type) => {
    drop.addEventListener(type, (event) => {
      event.preventDefault();
      drop.classList.add('border-pine', 'bg-pine/5');
    });
  });
  ['dragleave', 'drop'].forEach((type) => {
    drop.addEventListener(type, (event) => {
      event.preventDefault();
      drop.classList.remove('border-pine', 'bg-pine/5');
    });
  });
  drop.addEventListener('drop', (event) => {
    if (event.dataTransfer && event.dataTransfer.files.length) {
      input.files = event.dataTransfer.files;
      show();
    }
  });
}
</script>
JS;
}

function fm_render_app(string $root, string $envFile, string $self): void
{
    $requested = (string) ($_GET['dir'] ?? '');
    $opened = fm_open($root, $requested);
    if ($opened === null) {
        fm_redirect('', 'That folder is outside this site.', 'error');
    }
    $rel = $opened['rel'];
    $abs = $opened['abs'];
    $parts = $opened['parts'];
    $csrf = fm_csrf();
    $flash = $_SESSION['fm_flash'] ?? null;
    unset($_SESSION['fm_flash']);
    $list = fm_list($abs);
    $uploadMax = (string) (ini_get('upload_max_filesize') ?: '');
    $postMax = (string) (ini_get('post_max_size') ?: '');

    fm_head('Files');
    echo '<body class="min-h-dvh bg-paper text-ink antialiased">';
    echo '<header class="sticky top-0 z-20 flex h-14 items-center justify-between gap-4 border-b border-line bg-paper/95 px-4 backdrop-blur">';
    echo '<div class="flex min-w-0 items-center gap-2"><span class="text-pine">' . fm_icon('folder') . '</span>';
    echo '<h1 class="text-sm font-semibold">Files</h1>';
    echo '<span class="hidden truncate font-mono text-xs text-stone-500 sm:inline" title="' . fm_e($root) . '">' . fm_e($root) . '</span></div>';
    echo '<form method="post" action="' . fm_e(fm_url($rel)) . '">' . fm_fields($csrf, 'logout', $rel);
    echo '<button type="submit" class="rounded-lg px-2 py-1.5 text-sm text-stone-600 hover:bg-white">Log out</button></form>';
    echo '</header>';
    echo '<div class="lg:grid lg:grid-cols-[17rem_minmax(0,1fr)]">';
    echo '<aside class="max-h-64 overflow-auto border-b border-line bg-ink px-3 py-4 text-stone-300 lg:max-h-none lg:min-h-[calc(100dvh-3.5rem)] lg:border-b-0 lg:border-r">';
    echo '<p class="px-2 pb-2 text-[11px] font-semibold uppercase tracking-[0.14em] text-stone-500">Folders</p>';
    echo fm_tree($root, $parts);
    echo '</aside>';
    echo '<main class="px-4 py-5 sm:px-6">';

    if (is_array($flash) && isset($flash['text'])) {
        $ok = ($flash['type'] ?? '') === 'ok';
        $tone = $ok
            ? 'border-emerald-200 bg-emerald-50 text-emerald-950'
            : 'border-rose-200 bg-rose-50 text-rose-950';
        echo '<p class="mb-4 rounded-xl border px-3 py-2 text-sm ' . $tone . '" role="status">' . fm_e((string) $flash['text']) . '</p>';
    }
    if (fm_env_is_public($envFile)) {
        echo '<p class="mb-4 rounded-xl border border-amber-200 bg-amber-50 px-3 py-2 text-sm text-amber-950">The .env file is inside the public web folder. Move it above the document root if the server would serve it.</p>';
    }

    echo '<nav class="flex flex-wrap items-center gap-1 text-sm text-stone-500" aria-label="Breadcrumb">';
    echo '<a class="rounded-md px-1.5 py-0.5 hover:bg-white hover:text-ink" href="' . fm_e(fm_url()) . '">' . fm_e(basename($root)) . '</a>';
    $walk = [];
    foreach ($parts as $index => $part) {
        $walk[] = $part;
        $crumb = implode('/', $walk);
        echo '<span class="text-stone-300">/</span>';
        if ($index === count($parts) - 1) {
            echo '<span class="px-1.5 font-medium text-ink" aria-current="page">' . fm_e($part) . '</span>';
        } else {
            echo '<a class="rounded-md px-1.5 py-0.5 hover:bg-white hover:text-ink" href="' . fm_e(fm_url($crumb)) . '">' . fm_e($part) . '</a>';
        }
    }
    echo '</nav>';

    echo '<div class="mt-4 grid gap-3 lg:grid-cols-[minmax(0,1fr)_16rem]">';
    echo '<form method="post" action="' . fm_e(fm_url($rel)) . '" enctype="multipart/form-data" class="rounded-2xl border border-line bg-white p-3">';
    echo fm_fields($csrf, 'upload', $rel);
    echo '<label id="drop" for="files" class="flex cursor-pointer flex-col items-start rounded-xl border border-dashed border-line px-4 py-4 transition">';
    echo '<input id="files" name="files[]" type="file" multiple class="sr-only">';
    echo '<span id="picked" class="text-sm text-stone-600">Drop files here, or browse.</span>';
    echo '<span class="mt-1 text-xs text-stone-400">Up to ' . fm_e($uploadMax !== '' ? $uploadMax : 'the server limit') . ' each, ' . fm_e($postMax !== '' ? $postMax : 'the server limit') . ' per request. Into this folder.</span>';
    echo '</label>';
    echo '<div class="mt-3 flex flex-wrap items-center justify-between gap-3">';
    echo '<label class="flex items-center gap-2 text-sm text-stone-600"><input type="checkbox" name="overwrite" value="1" class="size-4 accent-pine"> Replace files with the same name</label>';
    echo '<button type="submit" class="h-10 rounded-xl bg-pine px-4 text-sm font-semibold text-white hover:bg-pine-dark">Upload</button>';
    echo '</div></form>';
    echo '<form method="post" action="' . fm_e(fm_url($rel)) . '" class="flex flex-col justify-between rounded-2xl border border-line bg-white p-3">';
    echo fm_fields($csrf, 'mkdir', $rel);
    echo '<label class="text-sm font-medium" for="folder-name">New folder</label>';
    echo '<input id="folder-name" name="name" required maxlength="180" autocomplete="off" spellcheck="false" placeholder="folder-name" class="mt-2 h-10 rounded-xl border border-line px-3 text-sm outline-none ring-pine/20 focus:border-pine focus:ring-4">';
    echo '<button type="submit" class="mt-3 h-10 rounded-xl border border-line bg-paper text-sm font-medium hover:bg-white">Create folder</button>';
    echo '</form></div>';

    echo '<div class="mt-4 overflow-hidden rounded-2xl border border-line bg-white">';
    echo '<div class="flex items-center justify-between gap-3 border-b border-line px-3 py-2">';
    echo '<label class="sr-only" for="filter">Filter</label>';
    echo '<input id="filter" type="search" placeholder="Filter this folder" class="h-9 w-full max-w-xs rounded-lg border border-transparent bg-paper px-3 text-sm outline-none focus:border-line">';
    echo '<span class="shrink-0 text-xs text-stone-400">' . count($list['rows']) . ($list['truncated'] ? '+' : '') . ' items</span>';
    echo '</div>';

    if ($list['unreadable']) {
        echo '<p class="px-4 py-8 text-sm text-stone-500">This folder cannot be read.</p>';
    } else {
        if ($list['truncated']) {
            echo '<p class="border-b border-line px-4 py-2 text-xs text-amber-800">Showing the first ' . FM_LIST_LIMIT . ' names.</p>';
        }
        echo '<div class="overflow-x-auto"><table class="w-full min-w-[36rem] text-left text-sm">';
        echo '<thead class="text-xs uppercase tracking-wide text-stone-400"><tr>';
        echo '<th class="px-4 py-2 font-medium">Name</th>';
        echo '<th class="hidden px-3 py-2 font-medium md:table-cell">Size</th>';
        echo '<th class="hidden px-3 py-2 font-medium sm:table-cell">Modified</th>';
        echo '<th class="hidden px-3 py-2 font-medium lg:table-cell">Mode</th>';
        echo '<th class="px-4 py-2 text-right font-medium">Actions</th>';
        echo '</tr></thead><tbody>';

        if ($parts !== []) {
            $parent = implode('/', array_slice($parts, 0, -1));
            echo '<tr class="border-t border-line">';
            echo '<td class="px-4 py-2.5" colspan="5"><a class="inline-flex items-center gap-2 font-medium text-stone-600 hover:text-ink" href="' . fm_e(fm_url($parent)) . '">' . fm_icon('up') . ' Up</a></td>';
            echo '</tr>';
        }

        if ($list['rows'] === []) {
            echo '<tr class="border-t border-line"><td class="px-4 py-8 text-stone-500" colspan="5">This folder is empty.</td></tr>';
        }

        foreach ($list['rows'] as $row) {
            $childRel = ($rel === '' ? '' : $rel . '/') . $row['name'];
            $dot = str_starts_with($row['name'], '.');
            $locked = fm_protected($row['path'], $root, $envFile, $self);
            $icon = $row['dir'] ? 'folder' : fm_file_icon($row['name']);
            echo '<tr class="border-t border-line" data-name="' . fm_e($row['name']) . '">';
            echo '<td class="max-w-[18rem] px-4 py-2.5">';
            echo '<div class="flex items-center gap-2 ' . ($dot ? 'text-stone-500' : '') . '">';
            echo '<span class="' . ($row['dir'] ? 'text-pine' : 'text-stone-400') . '">' . fm_icon($icon) . '</span>';
            if ($row['dir'] && !$row['link']) {
                echo '<a class="truncate font-medium hover:underline" href="' . fm_e(fm_url($childRel)) . '" title="' . fm_e($row['name']) . '">' . fm_e($row['name']) . '</a>';
            } elseif (!$row['dir'] && !$row['link']) {
                echo '<a class="truncate hover:underline" href="' . fm_e(fm_url($rel, ['download' => $childRel])) . '" title="' . fm_e($row['name']) . '">' . fm_e($row['name']) . '</a>';
            } else {
                echo '<span class="truncate" title="' . fm_e($row['name']) . '">' . fm_e($row['name']) . '</span>';
                echo '<span class="rounded-md bg-paper px-1.5 py-0.5 text-[11px] uppercase tracking-wide text-stone-500">link</span>';
            }
            echo '</div></td>';
            echo '<td class="hidden px-3 py-2.5 text-stone-500 md:table-cell">' . ($row['dir'] || $row['link'] ? '—' : fm_e(fm_bytes((int) $row['size']))) . '</td>';
            echo '<td class="hidden px-3 py-2.5 text-stone-500 sm:table-cell">' . ($row['mtime'] > 0 ? fm_e(date('j M Y, H:i', (int) $row['mtime'])) : '—') . '</td>';
            echo '<td class="hidden px-3 py-2.5 font-mono text-xs text-stone-400 lg:table-cell">' . fm_e((string) $row['perms']) . '</td>';
            echo '<td class="px-4 py-2.5 text-right">';
            if ($locked) {
                echo '<span class="inline-flex items-center gap-1 text-xs text-stone-400">' . fm_icon('lock') . ' Protected</span>';
            } else {
                $label = str_replace(["\r", "\n"], ' ', $row['name']);
                if ($row['link']) {
                    $confirm = 'Remove the link ' . $label . '? The target is left as it is.';
                } elseif ($row['dir']) {
                    $confirm = 'Delete the folder ' . $label . ' and everything inside it?';
                } else {
                    $confirm = 'Delete ' . $label . '?';
                }
                echo '<form method="post" action="' . fm_e(fm_url($rel)) . '" data-confirm="' . fm_e($confirm) . '" class="inline">';
                echo fm_fields($csrf, 'delete', $rel);
                echo '<input type="hidden" name="path" value="' . fm_e($childRel) . '">';
                echo '<button type="submit" class="rounded-lg px-2 py-1 text-sm text-rose-700 hover:bg-rose-50">Delete</button>';
                echo '</form>';
            }
            echo '</td></tr>';
        }
        echo '</tbody></table></div>';
    }
    echo '</div></main></div>';
    echo fm_script();
    echo '</body></html>';
}

function fm_handle_login(array $config): void
{
    if (!fm_csrf_ok()) {
        fm_render_login('The form expired. Refresh and try again.');

        return;
    }
    if (!fm_throttle('check')) {
        fm_render_login('Too many attempts. Wait five minutes.');

        return;
    }
    $given = (string) ($_POST['password'] ?? '');
    if (!fm_password_ok($config['password'], $given)) {
        fm_throttle('fail');
        usleep(400000);
        $message = fm_throttle('check')
            ? 'That password does not match.'
            : 'Too many attempts. Wait five minutes.';
        fm_render_login($message);

        return;
    }
    fm_throttle('reset');
    session_regenerate_id(true);
    $_SESSION['fm_csrf'] = bin2hex(random_bytes(32));
    $_SESSION['fm_auth'] = fm_auth_token($config['password'], $config['root']);
    fm_redirect('');
}

function fm_handle_logout(): never
{
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', [
            'expires' => time() - 42000,
            'path' => $params['path'],
            'domain' => $params['domain'],
            'secure' => (bool) $params['secure'],
            'httponly' => (bool) $params['httponly'],
            'samesite' => 'Strict',
        ]);
    }
    session_destroy();
    header('Location: ' . fm_script_name(), true, 303);
    exit;
}

function fm_handle_upload(string $root, string $rel, string $abs, string $envFile, string $self): never
{
    $files = fm_uploaded_list();
    $incoming = array_values(array_filter($files, static fn (array $file): bool => $file['error'] !== UPLOAD_ERR_NO_FILE));
    if ($incoming === []) {
        fm_redirect($rel, 'Choose a file to upload.', 'error');
    }
    $overwrite = (($_POST['overwrite'] ?? '') === '1');
    $saved = 0;
    $problems = [];
    foreach ($incoming as $file) {
        $rawName = $file['name'] !== '' ? $file['name'] : 'file';
        if ($file['error'] !== UPLOAD_ERR_OK) {
            $problems[] = $rawName . ' ' . fm_upload_error($file['error']);
            continue;
        }
        $name = fm_safe_name($file['name']);
        if ($name === null) {
            $problems[] = 'A file name was not allowed.';
            continue;
        }
        if (fm_name_blocked($abs, $name, $envFile, $self)) {
            $problems[] = $name . ' is protected.';
            continue;
        }
        $dest = $abs . DIRECTORY_SEPARATOR . $name;
        if (is_link($dest)) {
            $problems[] = $name . ' is a link.';
            continue;
        }
        if (is_dir($dest)) {
            $problems[] = $name . ' is a folder.';
            continue;
        }
        if (is_file($dest)) {
            $existing = realpath($dest);
            if ($existing === false || !fm_inside($root, $existing)) {
                $problems[] = $name . ' is outside this site.';
                continue;
            }
            if (!$overwrite) {
                $problems[] = $name . ' already exists.';
                continue;
            }
        }
        if (!is_uploaded_file($file['tmp']) || !@move_uploaded_file($file['tmp'], $dest)) {
            $problems[] = $name . ' could not be saved.';
            continue;
        }
        $saved++;
    }
    if ($saved === 0 && $problems === []) {
        fm_redirect($rel, 'Nothing was uploaded.', 'error');
    }
    $text = $saved === 1 ? '1 file uploaded.' : $saved . ' files uploaded.';
    if ($problems !== []) {
        $text .= ' ' . implode(' ', array_slice($problems, 0, 4));
        if (count($problems) > 4) {
            $text .= ' …';
        }
    }
    fm_redirect($rel, $text, $saved === 0 ? 'error' : 'ok');
}

function fm_handle_mkdir(string $rel, string $abs): never
{
    $name = fm_safe_name((string) ($_POST['name'] ?? ''));
    if ($name === null || str_contains($name, '/') || str_contains($name, '\\')) {
        fm_redirect($rel, 'That folder name is not allowed.', 'error');
    }
    $dest = $abs . DIRECTORY_SEPARATOR . $name;
    if (file_exists($dest) || is_link($dest)) {
        fm_redirect($rel, 'That name is already in this folder.', 'error');
    }
    if (!@mkdir($dest, 0755)) {
        fm_redirect($rel, 'The folder could not be created.', 'error');
    }
    $next = $rel === '' ? $name : $rel . '/' . $name;
    fm_redirect($next, 'Folder created.');
}

function fm_handle_delete(string $root, string $rel, string $envFile, string $self): never
{
    $pathRel = (string) ($_POST['path'] ?? '');
    $target = fm_target($root, $pathRel);
    if ($target === null) {
        fm_redirect($rel, 'That item is outside this site.', 'error');
    }
    try {
        fm_delete_path($target, $root, $envFile, $self);
    } catch (RuntimeException $e) {
        $message = $e->getMessage() === 'protected'
            ? 'That item is protected and was left in place.'
            : 'Could not delete that item.';
        fm_redirect($rel, $message, 'error');
    }
    $back = fm_open($root, $rel);
    fm_redirect($back['rel'] ?? '', 'Deleted.');
}

function fm_download(string $root, string $rel): never
{
    $target = fm_target($root, $rel);
    if ($target === null) {
        fm_redirect_open($root, '', 'That file is outside this site.', 'error');
    }
    if (is_link($target)) {
        $real = realpath($target);
        if ($real === false || !is_file($real) || !fm_inside($root, $real)) {
            fm_redirect_open($root, '', 'That link points outside this site.', 'error');
        }
        $target = $real;
    }
    $real = realpath($target);
    if ($real === false || !is_file($real) || !fm_inside($root, $real)) {
        fm_redirect_open($root, '', 'That file is not available.', 'error');
    }
    $name = basename($real);
    $safe = str_replace(['"', "\r", "\n"], '', $name);
    fm_security_headers();
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . $safe . '"; filename*=UTF-8\'\'' . rawurlencode($name));
    $size = filesize($real);
    if ($size !== false) {
        header('Content-Length: ' . $size);
    }
    readfile($real);
    exit;
}

function fm_run(): void
{
    if (PHP_VERSION_ID < 80400) {
        http_response_code(500);
        header('Content-Type: text/plain; charset=UTF-8');
        echo 'PHP 8.4 or newer is required.';

        return;
    }

    $config = fm_config(__DIR__, true);
    if (!$config['ok']) {
        fm_session();
        fm_render_setup($config['error']);

        return;
    }

    fm_session();

    if (fm_request_too_large()) {
        if (!fm_authed($config)) {
            fm_render_login('That upload is larger than the server allows.');

            return;
        }
        fm_redirect_open($config['root'], (string) ($_GET['dir'] ?? ''), 'That upload is larger than the server allows.', 'error');
    }

    $action = (string) ($_POST['action'] ?? '');
    if ($action === 'login') {
        fm_handle_login($config);

        return;
    }
    if (!fm_authed($config)) {
        fm_render_login(null);

        return;
    }
    if ($action === 'logout') {
        if (!fm_csrf_ok()) {
            fm_redirect_open($config['root'], (string) ($_POST['dir'] ?? ''), 'The form expired. Try again.', 'error');
        }
        fm_handle_logout();
    }
    if ($action !== '' && !fm_csrf_ok()) {
        fm_redirect_open($config['root'], (string) ($_POST['dir'] ?? ''), 'The form expired. Try again.', 'error');
    }

    $rel = (string) ($_POST['dir'] ?? $_GET['dir'] ?? '');
    $opened = fm_open($config['root'], $rel);
    if ($action !== '' && $opened === null) {
        fm_redirect('', 'That folder is outside this site.', 'error');
    }

    if ($action === 'upload' && $opened !== null) {
        fm_handle_upload($config['root'], $opened['rel'], $opened['abs'], $config['env_file'], $config['self']);
    }
    if ($action === 'mkdir' && $opened !== null) {
        fm_handle_mkdir($opened['rel'], $opened['abs']);
    }
    if ($action === 'delete' && $opened !== null) {
        fm_handle_delete($config['root'], $opened['rel'], $config['env_file'], $config['self']);
    }
    if (isset($_GET['download'])) {
        fm_download($config['root'], (string) $_GET['download']);
    }

    fm_render_app($config['root'], $config['env_file'], $config['self']);
}

function fm_self_test(): void
{
    $failures = [];
    $assert = static function (bool $condition, string $message) use (&$failures): void {
        if (!$condition) {
            $failures[] = $message;
            fwrite(STDERR, "FAIL {$message}\n");
        }
    };

    $assert(fm_unquote_env('"secret#keep"') === 'secret#keep', 'quoted hash stays');
    $assert(fm_unquote_env('plain # comment') === 'plain', 'inline comment drops');
    $assert(fm_safe_name('../etc/passwd') === 'passwd', 'basename strips traversal');
    $assert(fm_safe_name('..') === null, 'dotdot name rejected');
    $assert(fm_parts('a/../../etc') === null, 'dotdot segment rejected');
    $assert(fm_parts('docs/images') === ['docs', 'images'], 'plain parts stay');
    $assert(fm_is_broad_root('/'), 'filesystem root is broad');
    $assert(fm_password_ok('correct-horse', 'correct-horse'), 'plain password matches');
    $assert(!fm_password_ok('correct-horse', 'wrong-password'), 'plain password rejects');
    $hash = password_hash('correct-horse', PASSWORD_DEFAULT);
    $assert(fm_password_ok($hash, 'correct-horse'), 'hash password matches');

    $base = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'fm-test-' . bin2hex(random_bytes(4));
    $parent = $base . '/parent';
    $site = $parent . '/site';
    $public = $site . '/public';
    $outside = $base . '/outside';
    mkdir($public, 0755, true);
    mkdir($outside, 0755, true);
    file_put_contents($parent . '/.env', "FILEMANAGER_PASSWORD=parent-password-ok\nFILEMANAGER_ROOT=" . $parent . "\n");
    file_put_contents($site . '/.env', "FILEMANAGER_PASSWORD=\"site-password-ok\"\n# comment\nexport OTHER=nope\n");
    file_put_contents($public . '/index.html', 'hello');
    file_put_contents($outside . '/secret.txt', 'secret');
    mkdir($site . '/docs', 0755, true);
    symlink($outside, $site . '/leak');
    symlink($outside . '/secret.txt', $site . '/leak.txt');
    symlink($site . '/docs', $site . '/alias');

    try {
        $config = fm_config($public, false);
        $assert($config['ok'] === true, 'config ok');
        $assert($config['password'] === 'site-password-ok', 'nearest password wins');
        $assert($config['root'] === realpath($site), 'root defaults to the .env folder');
        $assert(!fm_inside($config['root'], realpath($outside . '/secret.txt') ?: ''), 'outside file is outside root');

        $opened = fm_open($config['root'], 'public');
        $assert($opened !== null && $opened['abs'] === realpath($public), 'open public');
        $assert(fm_open($config['root'], '../outside') === null, 'open rejects traversal');
        $assert(fm_open($config['root'], 'leak') === null, 'open rejects symlink to outside dir');
        $alias = fm_open($config['root'], 'alias');
        $assert($alias !== null && $alias['abs'] === realpath($site . '/docs'), 'open follows inside symlink');
        $tree = fm_dir_names($config['root'], $config['root']);
        $assert(in_array('docs', $tree['names'], true), 'tree lists docs');
        $assert(in_array('alias', $tree['names'], true), 'tree lists an inside link');
        $assert(!in_array('leak', $tree['names'], true), 'tree hides an outside link');

        $file = fm_target($config['root'], 'public/index.html');
        $assert($file !== null && is_file($file), 'target file');
        $assert(fm_target($config['root'], 'leak.txt') !== null && is_link(fm_target($config['root'], 'leak.txt')), 'target keeps outside symlink as a link');
        $assert(fm_name_blocked($site, '.env', $config['env_file'], $config['self']), '.env name blocked');
        $assert(!fm_name_blocked($public, 'photo.jpg', $config['env_file'], $config['self']), 'normal name allowed');

        file_put_contents($site . '/gone.txt', 'x');
        fm_delete_path($site . '/gone.txt', $config['root'], $config['env_file'], $config['self']);
        $assert(!file_exists($site . '/gone.txt'), 'file deleted');

        $threw = false;
        try {
            fm_delete_path($config['env_file'], $config['root'], $config['env_file'], $config['self']);
        } catch (RuntimeException $e) {
            $threw = $e->getMessage() === 'protected';
        }
        $assert($threw && is_file($config['env_file']), '.env delete refused');

        fm_delete_path($site . '/leak.txt', $config['root'], $config['env_file'], $config['self']);
        $assert(!is_link($site . '/leak.txt') && is_file($outside . '/secret.txt'), 'symlink delete leaves the outside file');

        mkdir($site . '/box', 0755, true);
        file_put_contents($site . '/box/a.txt', 'a');
        fm_delete_path($site . '/box', $config['root'], $config['env_file'], $config['self']);
        $assert(!is_dir($site . '/box'), 'folder deleted');

        mkdir($site . '/nest', 0755, true);
        file_put_contents($site . '/nest/keeper.txt', 'k');
        file_put_contents($site . '/nest/other.txt', 'o');
        $kept = false;
        try {
            fm_delete_path($site . '/nest', $config['root'], $config['env_file'], realpath($site . '/nest/keeper.txt') ?: '');
        } catch (RuntimeException $e) {
            $kept = $e->getMessage() === 'protected';
        }
        $assert($kept && is_file($site . '/nest/other.txt'), 'folder with a protected file is left intact');

        file_put_contents($site . '/.env', "FILEMANAGER_PASSWORD=short\n");
        $short = fm_config($public, false);
        $assert($short['ok'] === false && $short['error'] === 'short_password', 'short password rejected');

        file_put_contents($site . '/.env', "FILEMANAGER_PASSWORD=long-enough-password\nFILEMANAGER_ROOT=/\n");
        $broad = fm_config($public, false);
        $assert($broad['ok'] === false && $broad['error'] === 'broad_root', 'broad root rejected');

        $_SERVER['REMOTE_ADDR'] = '203.0.113.50';
        @unlink(fm_throttle_file());
        $assert(fm_throttle('check') === true, 'throttle starts open');
        for ($i = 0; $i < FM_LOCK_AFTER - 1; $i++) {
            fm_throttle('fail');
        }
        $assert(fm_throttle('check') === true, 'throttle still open before the limit');
        fm_throttle('fail');
        $assert(fm_throttle('check') === false, 'throttle locks');
        fm_throttle('reset');
        $assert(fm_throttle('check') === true, 'throttle resets');
        @unlink(fm_throttle_file());
    } finally {
        $cleanup = static function (string $path) use (&$cleanup): void {
            if (is_link($path)) {
                unlink($path);

                return;
            }
            if (is_dir($path)) {
                $items = scandir($path, SCANDIR_SORT_NONE);
                if (is_array($items)) {
                    foreach ($items as $item) {
                        if ($item === '.' || $item === '..') {
                            continue;
                        }
                        $cleanup($path . DIRECTORY_SEPARATOR . $item);
                    }
                }
                rmdir($path);

                return;
            }
            if (is_file($path)) {
                unlink($path);
            }
        };
        if (is_dir($base)) {
            $cleanup($base);
        }
    }

    if ($failures !== []) {
        fwrite(STDERR, count($failures) . " failed\n");
        exit(1);
    }
    fwrite(STDOUT, "ok\n");
}

if (PHP_SAPI === 'cli' && in_array('--self-test', $_SERVER['argv'] ?? [], true)) {
    fm_self_test();
    exit;
}

fm_run();
