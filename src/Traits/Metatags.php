<?php
namespace Maksuco\Helpers\Traits;

trait Metatags {

	function vite($entry) {
		static $manifest;
		static $config;

		if (!$manifest) {
			$manifestPath = $_SERVER['DOCUMENT_ROOT'].'/assets/build/manifest.json';
			$manifest = json_decode(file_get_contents($manifestPath), true);
			// if(isset(config('app.env')) && config('app.env') === 'local') {
			// 	$path = '/assets/css/';
			// } else {
			// 	$path = '/assets/build/';
			// }
		}

		// allow lookup by "name" (frontend, frontend-css)
		foreach ($manifest as $item) {
			if (($item['name'] ?? null) === $entry) {
				$file = $item['file'];

				return str_ends_with($file, '.css')
					? '<link rel="stylesheet" href="/assets/build/'.$file.'">'
					: '<script type="module" src="/assets/build/'.$file.'"></script>';
			}
		}

		// fallback: direct key (assets/js/stak.js)
		if (isset($manifest[$entry])) {
			$file = $manifest[$entry]['file'];

			return str_ends_with($file, '.css')
				? '<link rel="stylesheet" href="/assets/build/'.$file.'">'
				: '<script type="module" src="/assets/build/'.$file.'"></script>';
		}

		return '';
	}

	/**
	 * Plain text, cut to $limit characters at a word boundary.
	 * Decodes entities, strips tags, collapses whitespace, never cuts mid-word and
	 * drops a dangling connector or punctuation left at the end ("de", "and", "&", ",").
	 * Returns UNESCAPED text: escape with metaAttr() before putting it in HTML.
	 */
	function metaText($text, int $limit): string
	{
		if (is_array($text) || is_object($text)) {
			return '';
		}
		$text = html_entity_decode(strip_tags((string) $text), ENT_QUOTES | ENT_HTML5, 'UTF-8');
		$text = trim(preg_replace('/\s+/u', ' ', $text));
		if ($limit <= 0 || mb_strlen($text, 'UTF-8') <= $limit) {
			return $text;
		}

		$cut = mb_substr($text, 0, $limit, 'UTF-8');
		$nextChar = mb_substr($text, $limit, 1, 'UTF-8');
		if ($nextChar !== '' && !preg_match('/\s/u', $nextChar)) {
			// We are inside a word: go back to the last space (unless that loses too much)
			$lastSpace = mb_strrpos($cut, ' ', 0, 'UTF-8');
			if ($lastSpace !== false && $lastSpace >= (int) floor($limit * 0.5)) {
				$cut = mb_substr($cut, 0, $lastSpace, 'UTF-8');
			}
		}

		$connectors = ['a','an','and','the','of','for','to','with','or','in','on','at','by','from','y','e','o','u','de','del','la','el','los','las','en','con','para','por','un','una','al'];
		for ($i = 0; $i < 3; $i++) {
			$before = $cut;
			$cut = preg_replace('/[\s\p{P}\p{S}]+$/u', '', $cut); // trailing punctuation / & | - :
			$words = explode(' ', $cut);
			if (count($words) > 1 && in_array(mb_strtolower(end($words), 'UTF-8'), $connectors, true)) {
				array_pop($words);
				$cut = implode(' ', $words);
			}
			if ($cut === $before) {
				break;
			}
		}

		return trim($cut);
	}

	/** Escape a value for an HTML attribute (or text node) without double encoding. */
	function metaAttr($value): string
	{
		return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8', false);
	}

	// $meta['metatags']['title'] or $meta['title']
	// $meta['metatags']['description'] or ...
	// $meta['domain']
	// $meta['image']
	// Optional (all opt-in): author, notranslate, type, ogType, username, locales [lang => 'es_CO'],
	// imageWidth, imageHeight, twitterSite, siteName, siteSchema, sameAs, logo, local [street, city, state, zip|postalCode, country], geo [lat, long]
	function metatags($meta, $currentLang, $langs): string
	{
    	$meta = json_decode(json_encode($meta), true) ?: [];
		$langs = is_array($langs) ? array_values($langs) : [];
		$domain = $meta['domain'] ?? config('app.url') ?? ''; // Full URL https://maksuco.com
		$url = $domain !== '' ? rtrim($this->link($domain), '/') : '';
		$mainLang = current($langs);
		$appName = (string) (config('app.name') ?? '');
		$siteName = (string) ($meta['siteName'] ?? $appName); // og:site_name, e.g. a customer's brand on a custom domain

		$titleText = $this->metaText($meta['title'] ?? $meta['metatags']['title'][$currentLang] ?? '', 60);
		$descriptionText = $this->metaText($meta['description'] ?? $meta['metatags']['description'][$currentLang] ?? '', 160);
		$title = $this->metaAttr($titleText);
		$description = $this->metaAttr($descriptionText);
		//$keywords = substr($meta['keywords'] ?? $meta['metatags']['keywords'][$currentLang] ?? '', 0, 160);
		$image = !empty($meta['image']) ? $this->link($meta['image']) : '';
		$imageOG = !empty($meta['imageOG']) ? $this->link($meta['imageOG']) : $image;
		$author = $meta['author'] ?? '';

		// schema.org @type: must be a non-numeric string (CMS sometimes sends 1)
		$type = $meta['type'] ?? 'WebPage';
		if (!is_string($type) || trim($type) === '' || is_numeric($type)) {
			$type = 'WebPage';
		}
		$type = trim($type);
		if (!empty($meta['ogType']) && is_string($meta['ogType']) && !is_numeric($meta['ogType'])) {
			$ogType = strtolower(trim($meta['ogType']));
		} else {
			$ogType = match(strtolower($type)) {
				'profilepage', 'person' => 'profile',
				'article', 'blogposting', 'newsarticle' => 'article',
				default => 'website',
			};
		}
		$icon = !empty($meta['icon']) ? $this->link($meta['icon']) : '';

		$domainHost = parse_url($url, PHP_URL_HOST) ?: '';
		$imageHost = !empty($image) ? (parse_url($image, PHP_URL_HOST) ?: '') : '';
		$s3Dns = ($imageHost && $imageHost !== $domainHost) ? '<link rel="dns-prefetch" href="//'.$this->metaAttr($imageHost).'">' : "";
		$robot = empty($meta['noindex'])? 'index, follow' : 'noindex, nofollow';

		$metaTags = '
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="robots" content="'.$robot.'">
		<link rel="dns-prefetch" href="//'.$this->metaAttr($domainHost).'">'.$s3Dns.'
		<title>'.$title.'</title>
		<meta name="description" content="'.$description.'">';
		if (!empty($author)) {
			$metaTags .= '<meta name="author" content="'.$this->metaAttr($author).'">';
		}
		if (!empty($meta['notranslate'])) {
			$metaTags .= '<meta name="google" content="notranslate">';
		}
		if(empty($icon)) {
			$metaTags .= '
			<link rel="shortcut icon" href="'.$url.'/assets/favicon/favicon.png">
			<link rel="icon" href="'.$url.'/favicon.ico">
			<link rel="apple-touch-icon" href="'.$url.'/assets/favicon/apple-touch-icon.png">
  	  	    <link rel="icon" type="image/x-icon" href="/assets/favicon/favicon.png">
			<link rel="icon" type="image/png" href="'.$url.'/assets/favicon/favicon.png">
			<link rel="icon" type="image/svg+xml" href="'.$url.'/assets/favicon/favicon.svg">
			';
		} else {
			$iconExt = strtolower(pathinfo(parse_url($icon, PHP_URL_PATH) ?: '', PATHINFO_EXTENSION));
			$iconType = match($iconExt) {
				'svg' => 'image/svg+xml',
				'jpg', 'jpeg' => 'image/jpeg',
				'ico' => 'image/x-icon',
				'webp' => 'image/webp',
				default => 'image/png',
			};
			$iconAttr = $this->metaAttr($icon);
			$metaTags .= '
			<link rel="shortcut icon" href="'.$iconAttr.'">
			<link rel="icon" href="'.$iconAttr.'">
			<link rel="apple-touch-icon" href="'.$iconAttr.'">
			<link rel="icon" type="'.$iconType.'" href="'.$iconAttr.'">
			';
		}

		$prepent = $meta['slugsPrepend'] ?? []; //sample 'en'=>'services/'
		//ray('Metatags.php debug',$currentLang);
		if(!empty($meta['slugs'])) {
			$meta['canonical'] = rtrim($this->link($url.'/'.($meta['canonical'] ?? (($prepent[$currentLang] ?? '').$meta['slugs'][$currentLang]))), '/');
            if(!empty($meta['x-default'])){
                $default = rtrim($this->link($url.'/'.$meta['x-default']), '/');
            } else {
				$default = rtrim($this->link($url.'/'.($prepent[$mainLang] ?? '').$meta['slugs'][$mainLang]), '/');
            }
            $metaTags .= '<link rel="alternate" hreflang="x-default" href="'.$this->metaAttr($default).'"/>';
			if(count($langs) > 1) {
				foreach($langs as $langKey) {
					$altUrl = rtrim($this->link($url.'/'.($prepent[$langKey] ?? '').$meta['slugs'][$langKey]), '/');
					$metaTags .= '<link rel="alternate" hreflang="'.$this->metaAttr($langKey).'" href="'.$this->metaAttr($altUrl).'">';
				}
			}
		} else {
			$meta['canonical'] ??= $this->link(($_SERVER['HTTP_HOST'] ?? '').($_SERVER['REQUEST_URI'] ?? ''));
			$meta['canonical'] = $this->link($meta['canonical']);
			$metaTags .= '<link rel="alternate" hreflang="x-default" href="'.$this->metaAttr($meta['canonical']).'"/>';
		}
		$canonical = $this->metaAttr($meta['canonical']);
		$metaTags .= '<link rel="canonical" href="'.$canonical.'">';

		// Twitter
		$twitterSite = $meta['twitterSite'] ?? config('app.twitter') ?? '';
		$twitterSite = is_string($twitterSite) ? trim($twitterSite) : '';
		if ($twitterSite !== '' && !str_starts_with($twitterSite, '@')) {
			$twitterSite = '@'.ltrim(preg_replace('~^https?://(www\.)?(twitter|x)\.com/~i', '', $twitterSite), '@/');
		}
		$twitterMetaTags = '
		<meta name="twitter:card" content="summary_large_image">
		<meta name="twitter:title" content="'.$title.'">
		<meta name="twitter:description" content="'.$description.'">
		<meta name="twitter:image" content="'.$this->metaAttr($imageOG).'">
		<meta name="twitter:url" content="'.$canonical.'">';
		if ($twitterSite !== '' && $twitterSite !== '@') {
			$twitterMetaTags .= '<meta name="twitter:site" content="'.$this->metaAttr($twitterSite).'">';
		}

		// Open Graph
		$localeMap = array_merge(['en' => 'en_US', 'es' => 'es_ES', 'pt' => 'pt_BR', 'fr' => 'fr_FR', 'de' => 'de_DE', 'it' => 'it_IT'], is_array($meta['locales'] ?? null) ? $meta['locales'] : []);
		$toLocale = function ($lang) use ($localeMap) {
			$lang = (string) $lang;
			if (isset($localeMap[$lang])) {
				return $localeMap[$lang];
			}
			if (preg_match('/^([a-z]{2})[-_]([a-z]{2})$/i', $lang, $m)) {
				return strtolower($m[1]).'_'.strtoupper($m[2]);
			}
			return preg_match('/^[a-z]{2}$/i', $lang) ? strtolower($lang).'_'.strtoupper($lang) : '';
		};
		$ogMetaTags = '
		<meta property="og:type" content="'.$this->metaAttr($ogType).'">';
		if ($siteName !== '') {
			$ogMetaTags .= '<meta property="og:site_name" content="'.$this->metaAttr($siteName).'">';
		}
		$ogMetaTags .= '
		<meta property="og:title" content="'.$title.'">
		<meta property="og:description" content="'.$description.'">
		<meta property="og:image" content="'.$this->metaAttr($imageOG).'">';
		if ($imageOG !== '') {
			$ogMetaTags .= '<meta property="og:image:alt" content="'.$title.'">';
			if (!empty($meta['imageWidth']) && !empty($meta['imageHeight'])) {
				$ogMetaTags .= '<meta property="og:image:width" content="'.(int) $meta['imageWidth'].'"><meta property="og:image:height" content="'.(int) $meta['imageHeight'].'">';
			}
		}
		$ogMetaTags .= '<meta property="og:url" content="'.$canonical.'">';
		$currentLocale = $toLocale($currentLang);
		if ($currentLocale !== '') {
			$ogMetaTags .= '<meta property="og:locale" content="'.$this->metaAttr($currentLocale).'">';
			foreach ($langs as $langKey) {
				$altLocale = $toLocale($langKey);
				if ($altLocale !== '' && $altLocale !== $currentLocale) {
					$ogMetaTags .= '<meta property="og:locale:alternate" content="'.$this->metaAttr($altLocale).'">';
				}
			}
		}
		if ($ogType === 'profile' && !empty($meta['username']) && is_string($meta['username'])) {
			$ogMetaTags .= '<meta property="profile:username" content="'.$this->metaAttr(ltrim($meta['username'], '@')).'">';
		}

		// Optional JSON-LD data
		$name = $meta['name'] ?? '';
		if (!is_string($name) || trim($name) === '' || in_array(strtolower(trim($name)), ['index', 'home', 'inicio', 'homepage'], true)) {
			$name = $appName !== '' ? $appName : str_replace("www.", "", (string) parse_url($url, PHP_URL_HOST));
		}
		$jsonLd = [
			"@context" => "https://schema.org",
			"@type" => $type,
			"name" => ucfirst($name),
			"headline" => $titleText,
			"description" => $descriptionText,
			"image" => $image,
			"url" => $meta['canonical'],
			"inLanguage" => $currentLang
		];
		$local = (!empty($meta['local']) && is_array($meta['local'])) ? $meta['local'] : null;
		$geo = (!empty($meta['geo']) && is_array($meta['geo'])) ? $meta['geo'] : null;
		if(!empty($local)) {
			$jsonLd["address"] = array_filter([
				"@type" => "PostalAddress",
				"streetAddress"  => $local["street"] ?? null,
				"addressLocality"  => $local["city"] ?? null,
				"addressRegion"  => $local["state"] ?? null,
			], fn ($v) => $v !== null && $v !== '');
			$postalCode = $local["zip"] ?? $local["postalCode"] ?? null;
			if(!empty($postalCode)) {
				$jsonLd["address"]["postalCode"] = (string) $postalCode;
			}
			if(!empty($local["country"])) {
				$jsonLd["address"]["addressCountry"] = $local["country"];
			}
		}
		if(!empty($geo) && isset($geo["lat"], $geo["long"])) {
			$jsonLd["geo"] = [
				"@type" => "GeoCoordinates",
				"latitude" => $geo["lat"],
				"longitude" => $geo["long"]
			];
		}
		if(!empty($meta["jsExtras"]) && is_array($meta["jsExtras"])) {
			$jsonLd = array_merge($jsonLd, $meta["jsExtras"]);
		}
		if(!empty($meta["phone"])) {
			$jsonLd["telephone"] = (string) $meta["phone"];
		}
		$jsonFlags = JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_HEX_TAG;
		$jsonLdString = json_encode($jsonLd, $jsonFlags);
		$jsonLdScript = '<script type="application/ld+json">'.$jsonLdString.'</script>';

		// Site-level schema (Organization + WebSite): opt-in with $meta['siteSchema'],
		// or automatic on the app's own homepage (canonical is the root of config('app.url')
		// host, or the page's main-language slug is the root, e.g. "/" + "/inicio").
		$appHost = strtolower((string) (parse_url($this->link((string) (config('app.url') ?? '')), PHP_URL_HOST) ?: ''));
		$canonicalHost = strtolower((string) (parse_url($meta['canonical'], PHP_URL_HOST) ?: ''));
		$canonicalPath = trim((string) (parse_url($meta['canonical'], PHP_URL_PATH) ?? ''), '/');
		$isAppHost = $appHost !== '' && $canonicalHost !== '' && preg_replace('/^www\./', '', $canonicalHost) === preg_replace('/^www\./', '', $appHost);
		$isHome = $isAppHost && ($canonicalPath === '' || (!empty($meta['slugs']) && $mainLang !== false && trim((string) ($meta['slugs'][$mainLang] ?? 'x'), '/') === '' && empty($prepent[$mainLang])));
		if (!empty($meta['siteSchema']) || ($isHome && !array_key_exists('siteSchema', $meta))) {
			$siteUrl = $url !== '' ? $url : rtrim($this->link($canonicalHost), '/');
			$sameAs = $meta['sameAs'] ?? config('app.social');
			$sameAs = is_array($sameAs) ? array_values(array_filter($sameAs, fn ($v) => is_string($v) && $v !== '')) : [];
			$organization = [
				"@type" => "Organization",
				"@id" => $siteUrl."/#org",
				"name" => $appName !== '' ? $appName : $name,
				"url" => $siteUrl,
				"logo" => !empty($meta['logo']) ? $this->link($meta['logo']) : $siteUrl.'/assets/favicon/favicon.png',
			];
			if (!empty($sameAs)) {
				$organization["sameAs"] = $sameAs;
			}
			$siteLd = [
				"@context" => "https://schema.org",
				"@graph" => [
					$organization,
					[
						"@type" => "WebSite",
						"@id" => $siteUrl."/#website",
						"name" => $appName !== '' ? $appName : $name,
						"url" => $siteUrl,
						"publisher" => ["@id" => $siteUrl."/#org"],
						"inLanguage" => $currentLang,
					],
				],
			];
			$jsonLdScript .= '<script type="application/ld+json">'.json_encode($siteLd, $jsonFlags).'</script>';
		}

		if (!empty($meta['faqs'])) {
			$faqLd = [
				"@context" => "https://schema.org",
				"@type" => "FAQPage",
				"mainEntity" => []
			];
			foreach ($meta['faqs'] as $faq) {
				if (!empty($faq['question']) && !empty($faq['answer'])) {
					$faqLd["mainEntity"][] = [
						"@type" => "Question",
						"name" => $faq['question'],
						"acceptedAnswer" => [
							"@type" => "Answer",
							"text" => $faq['answer']
						]
					];
				}
			}
			if (!empty($faqLd["mainEntity"])) {
				$jsonLdScript .= '<script type="application/ld+json">'.json_encode($faqLd, $jsonFlags).'</script>';
			}
		}

		$metaTags .= $twitterMetaTags . $ogMetaTags . $jsonLdScript;
		return trim(preg_replace('/\s+/', ' ', $metaTags));
	}

}
