<?php
namespace Maksuco\Helpers\Traits;

trait MinifyHtml {

    public function minify_html(string $html): string
    {
        return version_compare(PHP_VERSION, '8.4.0', '>=')? $this->minify_html_dom($html) : $this->minify_html_regex($html);
    }

    private function minify_html_dom(string $html): string
    {
        $doc = \Dom\HTMLDocument::createFromString($html, LIBXML_NOERROR);
        $this->collapseWhitespace($doc->documentElement);
        return trim($doc->saveHTML());
    }

    private function collapseWhitespace(\Dom\Node $node): void
    {
        $preserveTags = ['pre', 'code', 'textarea', 'script', 'svg'];

        foreach (iterator_to_array($node->childNodes) as $child) {
            if ($child->nodeType === XML_TEXT_NODE) {
                $child->data = preg_replace('/\s+/', ' ', $child->data);
                continue;
            }

            if ($child->nodeType === XML_COMMENT_NODE) {
                $child->remove();
                continue;
            }

            if ($child->nodeType === XML_ELEMENT_NODE) {
                $tag = strtolower($child->nodeName);

                if ($child->hasAttribute('style')) {
                    $style = preg_replace(['/\s+/', '/;\s*$/', '/;\s*/'], [' ', '', '; '], trim($child->getAttribute('style')));
                    $child->setAttribute('style', $style); // collapse whitespace inside inline style attr
                }

                if ($tag === 'style') {
                    $child->textContent = preg_replace(['/\s+/', '/;\s*}/'], [' ', '}'], trim($child->textContent));
                    continue;
                }

                if (!in_array($tag, $preserveTags)) {
                    $this->collapseWhitespace($child);
                }
            }
        }
    }

    private function minify_html_regex(string $html): string
    {
        ini_set('pcre.backtrack_limit', 10_000_000);
        $original = $html;
        $placeholders = [];

        $html = preg_replace_callback('/<(pre|code|textarea|script|svg)\b(.*?)>(.*?)<\/\1>/is', function ($m) use (&$placeholders) {
            $key = "\x00PH" . count($placeholders) . "\x00";
            $placeholders[$key] = $m[0];
            return $key;
        }, $html); // 1. Preserve pre, code, textarea, script, svg content via placeholders
        if ($html === null) return trim($original);

        $steps = [
            fn($h) => preg_replace('/<!--(?!\s*(?:\[if [^\]]+]|<!|>))(?:(?!-->).)*-->/s', '', $h), // 2. Remove comments (except conditional comments)
            fn($h) => preg_replace('/\s+/', ' ', $h), // 3. Collapse whitespace
            fn($h) => preg_replace('/>\s+</', '><', $h), // 4. Remove unnecessary spaces between tags
            fn($h) => preg_replace('/\s*([=<>])\s*/', '$1', $h), // 5. Remove unnecessary spaces around attributes
            fn($h) => preg_replace('/=\s*"([^"]*?)"/', '="$1"', $h), // 6. Clean up spaces in attributes
            fn($h) => preg_replace('/<(\w+)([^>]*)\s+>/', '<$1$2>', $h), // 7. Remove unnecessary spaces before closing tags
        ];

        foreach ($steps as $step) {
            $result = $step($html);
            if ($result === null) { $html = null; break; }
            $html = $result;
        }

        if ($html === null) return trim($original);

        return trim(strtr($html, $placeholders)); // restore protected blocks
    }

}
