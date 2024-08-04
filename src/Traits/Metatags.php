<?php
namespace Maksuco\Helpers\Traits;

trait Metatags {
	
	function metatags($lang="en", $title="", $description="", $alternate=[], $keywords=false, $image=false, $url=false) {
		// CHECK
		$title = htmlspecialchars($title, ENT_QUOTES);
		$description = htmlspecialchars($description, ENT_QUOTES);
		$image = htmlspecialchars($image, ENT_QUOTES);
		if($url==false) {
			$domain = $_SERVER['HTTP_HOST'];
			$url = 'https://'.$domain.$_SERVER['REQUEST_URI'];
		} else {
			$domain = parse_url($url)['host'];
			$url = htmlspecialchars($url, ENT_QUOTES);
		}
		$host = 'https://' . $domain;
		
		// Generate Metas
		$metaTags = '
		<link rel="dns-prefetch" href="//'.$domain.'">
		<link rel="dns-prefetch" href="//'.str_replace("https://","",$image).'">
		<link rel="dns-prefetch" href="//www.googletagmanager.com">
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>'.$title.'</title>
		<meta name="description" content="'.$description.'">
		<meta name="author" content="Maksuco.com">
		<meta name="google" content="notranslate" />
		<link rel="shortcut icon" href="'.$host.'/assets/img/favicon.png">
		<link rel="icon" href="/favicon.ico">
		<link rel="apple-touch-icon" href="/assets/img/favicon.png">
		<link rel="icon" type="image/png" href="'.$host.'/assets/img/favicon.png">
		<link rel="icon" type="image/svg+xml" href="'.$host.'/assets/img/favicon.png">
		<link rel="canonical" href="'.$url.'">';
		
		foreach ($alternate as $alt) {
			if(isset($alt['lang'])) {
				$metaTags .= '<link rel="alternate" hreflang="'.$alt['lang'].'" href="'.$alt['url'].'">';
			}
		}
		
		// Generate Twitter meta tags
		$twitterMetaTags = '
		<meta name="twitter:card" content="summary_large_image">
		<meta name="twitter:title" content="'.$title.'">
		<meta name="twitter:description" content="'.$description.'">
		<meta name="twitter:image" content="'.$image.'">
		<meta name="twitter:url" content="'.$url.'">';
		
		// Generate Open Graph meta tags
		$ogMetaTags = '
		<meta property="og:type" content="website">
		<meta property="og:title" content="'.$title.'">
		<meta property="og:description" content="'.$description.'">
		<meta property="og:image" content="'.$image.'">
		<meta property="og:url" content="'.$url.'">';
				
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
		$metaTags .= $twitterMetaTags . $ogMetaTags . $jsonLdScript;
		return trim(preg_replace('/\s+/', ' ', $metaTags));
	}
}
