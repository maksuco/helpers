<?php
namespace Maksuco\Helpers\Traits;

trait Metatags {
	
	function metatags($lang="en", $title="", $description="", $alternative=[], $keywords=false, $image=false, $url=false) {
		// CHECK
		$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
		$host = $protocol . $_SERVER['HTTP_HOST'];
		if (!$url) {
			$url = $host.$_SERVER['REQUEST_URI'];
		}
		
		// Generate Metas
		$twitterMetaTags = '
			<title>' . htmlspecialchars($title, ENT_QUOTES) . '</title>
			<meta name="description" content="' . htmlspecialchars($description, ENT_QUOTES) . '">
			<link rel="canonical" href="' . htmlspecialchars($url, ENT_QUOTES) . '">
			<meta name="author" content="Maksuco.com">
			<meta name="google" content="notranslate" />
			<link rel="shortcut icon" href="' . $host. '/assets/img/favicon.png">
			<link rel="icon" href="/favicon.ico">
			<link rel="apple-touch-icon" href="/assets/img/favicon.png">
			<link rel="icon" type="image/png" href="' . $host. '/assets/img/favicon.png">
			<link rel="icon" type="image/svg+xml" href="' . $host. '/assets/img/favicon.png">';
		
		$alternativeMetaTags = '';
		foreach ($alternative as $alt) {
				if (isset($alt['lang']) && isset($alt['url'])) {
						$alternativeMetaTags .= '<link rel="alternate" hreflang="' . htmlspecialchars($alt['lang'], ENT_QUOTES) . '" href="' . htmlspecialchars($alt['url'], ENT_QUOTES) . '">';
				}
		}
		
		// Generate Twitter meta tags
		$twitterMetaTags = '
			<meta name="twitter:card" content="summary_large_image">
			<meta name="twitter:title" content="' . htmlspecialchars($title, ENT_QUOTES) . '">
			<meta name="twitter:description" content="' . htmlspecialchars($description, ENT_QUOTES) . '">
			<meta name="twitter:image" content="' . htmlspecialchars($image, ENT_QUOTES) . '">
			<meta name="twitter:url" content="' . htmlspecialchars($url, ENT_QUOTES) . '">';
		
		// Generate Open Graph meta tags
		$ogMetaTags = '
			<meta property="og:type" content="website">
			<meta property="og:title" content="' . htmlspecialchars($title, ENT_QUOTES) . '">
			<meta property="og:description" content="' . htmlspecialchars($description, ENT_QUOTES) . '">
			<meta property="og:image" content="' . htmlspecialchars($image, ENT_QUOTES) . '">
			<meta property="og:url" content="' . htmlspecialchars($url, ENT_QUOTES) . '">';
				
		// Generate JSON-LD script
		$jsonLd = [
				"@context" => "https://schema.org",
				"@type" => "WebPage",
				"name" => $title,
				"description" => $description,
				"image" => $image,
				"url" => $url
		];
		$jsonLdString = json_encode($jsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
		$jsonLdScript = '<script type="application/ld+json">' . $jsonLdString . '</script>';
		
		// Return combined meta tags and JSON-LD script
		return $jsonLdScript . $twitterMetaTags . $ogMetaTags . $alternativeMetaTags;
	}
}
