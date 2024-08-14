<?php
namespace Maksuco\Helpers\Traits;

trait Metatags {
	
	function metatags($lang="en", $title="", $description="", $canonical=false, $alternate=[], $defaultLang=false, $keywords=false, $image=false, $url=false) {
		// CHECK
		$title = htmlspecialchars(substr($title, 0, 60), ENT_QUOTES);
		$description = htmlspecialchars(substr($description, 0, 160), ENT_QUOTES);
		$image = htmlspecialchars($image, ENT_QUOTES);
		if($url==false) {
			$domain = $_SERVER['HTTP_HOST'];
			$url = 'https://'.$domain.$_SERVER['REQUEST_URI'];
			$canonical = ($canonical)? $domain.$canonical : $url;
		} else {
			$domain = parse_url($url)['host'];
			$url = htmlspecialchars($url, ENT_QUOTES);
			$canonical = ($canonical)? $domain.$canonical : $url;
		}
		$host = 'https://' . $domain;
		$s3 = parse_url($image)['host'];
		$s3Dns = ($domain != $s3)? '<link rel="dns-prefetch" href="//'.$s3.'">' : "";
		
		// Generate Metas
		$metaTags = '
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<link rel="dns-prefetch" href="//'.$domain.'">'.$s3Dns.'
		<link rel="dns-prefetch" href="//www.googletagmanager.com">
		<title>'.$title.'</title>
		<meta name="description" content="'.$description.'">
		<meta name="author" content="Maksuco.com">
		<meta name="google" content="notranslate" />
		<link rel="shortcut icon" href="'.$host.'/assets/img/favicon.png">
		<link rel="icon" href="/favicon.ico">
		<link rel="apple-touch-icon" href="/assets/img/favicon.png">
		<link rel="icon" type="image/png" href="'.$host.'/assets/img/favicon.png">
		<link rel="icon" type="image/svg+xml" href="'.$host.'/assets/img/favicon.png">
		<link rel="canonical" href="'.$canonical.'">';
		
		foreach ($alternate as $alt) {
			if(isset($alt['lang'])) {
				$metaTags .= '<link rel="alternate" hreflang="'.$alt['lang'].'" href="'.$alt['url'].'">';
			}
		}
		if($defaultLang) {
			$metaTags .= '<link rel="alternate" hreflang="x-default" href="'.$host.'/'.$defaultLang.'" />';
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
