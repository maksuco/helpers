<?php
namespace Maksuco\Helpers\Traits;

trait Metatags {
	
	function metatags($author = "Maksuco.com", $domain="", $title="", $description="", $keywords=false, $lang="en", $canonical=false, $alternate=[], $default=false, $image=false, $type="website", $phone=false, $local=false, $geo=false, $cat=false) {
		// CHECK
		$title = htmlspecialchars(substr($title, 0, 60), ENT_QUOTES);
		$description = htmlspecialchars(substr($description, 0, 160), ENT_QUOTES);
		$image = htmlspecialchars($image, ENT_QUOTES);
		$domain = str_replace('https://', '', $domain);
		$url = 'https://'.$domain;
		$canonical = $url.rtrim($canonical, '/');
		$s3 = parse_url($image)['host'];
		$s3Dns = ($s3 != $domain)? '<link rel="dns-prefetch" href="//'.$s3.'">' : "";
		
		// Generate Metas
		$metaTags = '
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<link rel="dns-prefetch" href="//'.$domain.'">'.$s3Dns.'
		<link rel="dns-prefetch" href="//www.googletagmanager.com">
		<title>'.$title.'</title>
		<meta name="description" content="'.$description.'">
		<meta name="author" content="'.$author.'">
		<meta name="google" content="notranslate" />
		<link rel="shortcut icon" href="'.$url.'/assets/img/favicon.png">
		<link rel="icon" href="'.$url.'/favicon.ico">
		<link rel="apple-touch-icon" href="'.$url.'/assets/img/favicon.png">
		<link rel="icon" type="image/png" href="'.$url.'/assets/img/favicon.png">
		<link rel="icon" type="image/svg+xml" href="'.$url.'/assets/img/favicon.png">
		<link rel="canonical" href="'.$canonical.'">';
		
		foreach ($alternate as $alt) {
			if(isset($alt['lang'])) {
				$metaTags .= '<link rel="alternate" hreflang="'.$alt['lang'].'" href="'.$url.rtrim($alt['url'], '/').'">';
			}
		}
		if($default !== false) {
			$default = $url.'/'.$default;
			$metaTags .= '<link rel="alternate" hreflang="x-default" href="'.rtrim($default, '/').'" />';
		}
		
		// Generate Twitter meta tags
		$twitterMetaTags = '
		<meta name="twitter:card" content="summary_large_image">
		<meta name="twitter:title" content="'.$title.'">
		<meta name="twitter:description" content="'.$description.'">
		<meta name="twitter:image" content="'.$image.'">
		<meta name="twitter:url" content="'.$canonical.'">';
		
		// Generate Open Graph meta tags
		$ogMetaTags = '
		<meta property="og:type" content="website">
		<meta property="og:title" content="'.$title.'">
		<meta property="og:description" content="'.$description.'">
		<meta property="og:image" content="'.$image.'">
		<meta property="og:url" content="'.$canonical.'">';
				
		// Generate JSON-LD script
		$jsonLd = [
			"@context" => "https://schema.org",
			"@type" => $type,
			"name" => $title,
			"description" => $description,
			"image" => $image,
			"url" => $canonical
		];
		if($local) {
			$jsonLd["address"] = [
				"@type" => "PostalAddress",
				"streetAddress"  => $local["street"],
				"addressLocality"  => $local["city"],
				"addressRegion"  => $local["state"],
				"postalCode"  => $local["zip"]
			];
			if($geo) {
				$jsonLd["geo"] = [
					"@type" => "GeoCoordinates",
					"latitude" => $geo["lat"],
					"longitude" => $geo["long"]
				];
			}
			if($phone) {
				$jsonLd["telephone"] = $phone;
			}
		}
		if($cat) {
			$jsonLd["servesCuisine"] = $cat;
		}
		$jsonLdString = json_encode($jsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
		$jsonLdScript = '<script type="application/ld+json">' . $jsonLdString . '</script>';
		
		// Return combined meta tags and JSON-LD script
		$metaTags .= $twitterMetaTags . $ogMetaTags . $jsonLdScript;
		return trim(preg_replace('/\s+/', ' ', $metaTags));
	}
	
	// function metaLink($url,$domain=false) {
	// 	$domain = $domain ?? $_SERVER['HTTP_HOST'];
	// 	if(!str_starts_with('http', $url)) {
	// 		$url = $domain.((str_starts_with('/', $url))? '':'/').$url;
	// 	};
	// 	return htmlspecialchars($url, ENT_QUOTES);
	// }
}
