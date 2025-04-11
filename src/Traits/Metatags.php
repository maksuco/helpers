<?php
namespace Maksuco\Helpers\Traits;

trait Metatags {

// $meta = [
//     // --- Required Fields ---
//     'domain' => 'https://maksuco.com', // Full base URL, no trailing slash
//     'title' => 'Maksuco - Página de Ejemplo', // Page-specific title
//     'description' => 'Esta es la descripción para la página de ejemplo en español.', // Page-specific description
//     'image' => 'https://maksuco.com/assets/img/og-image-es.jpg', // Absolute URL for the OG/Twitter image
//
//     // Required: Associative array of ALL language versions for THIS page
//     // Keys are language codes, values are relative paths (use '/' or '' for root)
//     'alternates' => [
//         'en' => '/example-page',   // Path for the English version of this page
//         'es' => '/pagina-ejemplo', // Path for the Spanish version of this page
//         // 'fr' => '/page-exemple', // Add other languages if applicable
//         // 'x-default' => '/example-page' // Optional: Explicitly set x-default path, otherwise $mainLang path is used
//     ],
//
//     // --- Optional Fields ---
//     'author' => 'Maksuco Development Team', // Optional: Author name
//     'type' => 'article', // Optional: OG type (website, article, product, etc.). Default: 'website'
//
//     // Optional: Keywords (can be string or array)
//     'keywords' => ['ejemplo', 'página', 'maksuco', 'español'],
//
//     // Optional: Local Business Info (for JSON-LD)
//     'local' => [
//         'street' => '123 Example St',
//         'city' => 'Exampleville',
//         'state' => 'CA',
//         'zip' => '90210', // Use 'zip' key as per function
//         'country' => 'US'
//     ],
//
//     // Optional: Geo Coordinates (for JSON-LD, requires 'local' usually)
//     'geo' => [
//         'lat' => '34.0522',
//         'long' => '-118.2437'
//     ],
//
//     // Optional: Phone Number (for JSON-LD, requires 'local' usually)
//     'phone' => '+1-555-123-4567',
//
// ];
	function metatags($meta, $currentLang, $langs): string
	{
    	$meta = json_decode(json_encode($meta), true);
		$domain = $meta['domain'] ?? ''; // Full URL https://maksuco.com
		$url = rtrim($domain, '/');
		$mainLang = current($langs);

		$title =  substr($meta['title'] ?? $meta['metatags']['title'][$currentLang] ?? '', 0, 60);
		$description = substr($meta['description'] ?? $meta['metatags']['description'][$currentLang] ?? '', 0, 160);
		$keywords = substr($meta['keywords'] ?? $meta['metatags']['keywords'][$currentLang] ?? '', 0, 160);
		$image = $meta['image'] ?? '';
		$author = 'Maksuco.com';
		$type = $meta['type'] ?? 'website';

		$domainHost = parse_url($url)['host'] ?? '';
		$imageHost = !empty($image) ? (parse_url($image)['host'] ?? '') : '';
		$s3Dns = ($imageHost && $imageHost !== $domainHost) ? '<link rel="dns-prefetch" href="//'.$imageHost.'">' : "";

		$metaTags = '
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<link rel="dns-prefetch" href="//'.$domainHost.'">'.$s3Dns.'
		<link rel="dns-prefetch" href="//www.googletagmanager.com">
		<title>'.$title.'</title>
		<meta name="description" content="'.$description.'">
		<meta name="keywords" content="'.$keywords.'">
		<meta name="author" content="'.$author.'">
		<meta name="google" content="notranslate" />
		<link rel="shortcut icon" href="'.$url.'/assets/img/favicon.png">
		<link rel="icon" href="'.$url.'/favicon.ico">
		<link rel="apple-touch-icon" href="'.$url.'/assets/img/favicon.png">
		<link rel="icon" type="image/png" href="'.$url.'/assets/img/favicon.png">
		<link rel="icon" type="image/svg+xml" href="'.$url.'/assets/img/favicon.png">';

		$prepent = $meta['slugsPrepend'] ?? []; //sample 'en'=>'services/'
		$canonical = $url.'/'.($meta['canonical'] ?? (($prepent[$currentLang] ?? '').$meta['slugs'][$currentLang]));
		$metaTags .= '<link rel="canonical" href="'.$canonical.'">';
		if(!empty($meta['slugs'])) {
			if(count($langs) > 1){
				$default = $url.'/'.($prepent[$mainLang] ?? '').$meta['slugs'][$mainLang];
				$metaTags .= '<link rel="alternate" hreflang="x-default" href="'.$default.'"/>';
				foreach($langs as $langKey){
					$altUrl = $url.'/'.($prepent[$langKey] ?? '').$meta['slugs'][$langKey];
					$metaTags .= '<link rel="alternate" hreflang="'.$langKey.'" href="'.$altUrl.'">';
				}
			}
		}

		$twitterMetaTags = '
		<meta name="twitter:card" content="summary_large_image">
		<meta name="twitter:title" content="'.$title.'">
		<meta name="twitter:description" content="'.$description.'">
		<meta name="twitter:image" content="'.$image.'">
		<meta property="twitter:url" content="'.$canonical.'">';

		$ogMetaTags = '
		<meta property="og:type" content="'.$type.'">
		<meta property="og:title" content="'.$title.'">
		<meta property="og:description" content="'.$description.'">
		<meta property="og:image" content="'.$image.'">
		<meta property="og:url" content="'.$canonical.'">';

		// Optional JSON-LD data
		$jsonLd = [
			"@context" => "https://schema.org",
			"@type" => $type,
			"name" => ucfirst($meta['name'] ?? str_replace("www.", "", parse_url($url, PHP_URL_HOST))),
			"headline" => $title,
			"description" => $description,
			"image" => $image,
			"url" => $canonical,
			"inLanguage" => $currentLang
		];
		if(!empty($local)) {
			$jsonLd["address"] = [
				"@type" => "PostalAddress",
				"streetAddress"  => $local["street"],
				"addressLocality"  => $local["city"],
				"addressRegion"  => $local["state"]
			];
			if(!empty($local["postalCode"])) {
				$jsonLd["address"]["postalCode"] = $local["zip"];
			}
			if($local["country"]) {
				$jsonLd["address"]["addressCountry"] = $local["country"];
			}
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
		if(!empty($cat)) {
			$jsonLd["keywords"] = $cat;
		}
		$jsonLdString = json_encode($jsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
		$jsonLdScript = '<script type="application/ld+json">' . $jsonLdString . '</script>';

		$metaTags .= $twitterMetaTags . $ogMetaTags . $jsonLdScript;
		return trim(preg_replace('/\s+/', ' ', $metaTags));
	}


	// function metatags($author = "Maksuco.com", $domain="", $title="", $description="", $keywords=false, $lang="en", $canonical=false, $alternate=[], $default=false, $image=false, $type="website", $phone=false, $local=false, $geo=false, $cat=false) {
	// 	// CHECK
	// 	$title = htmlspecialchars(substr($title, 0, 60), ENT_QUOTES);
	// 	$description = htmlspecialchars(substr($description, 0, 160), ENT_QUOTES);
	// 	$image = htmlspecialchars($image, ENT_QUOTES);
	// 	$domain = str_replace('https://', '', $domain);
	// 	$url = 'https://'.$domain;
	// 	$canonical = $url.str_replace("//", "/", "/".$canonical);
	// 	$s3 = parse_url($image)['host'];
	// 	$s3Dns = ($s3 != $domain)? '<link rel="dns-prefetch" href="//'.$s3.'">' : "";
	//
	// 	// Generate Metas
	// 	$metaTags = '
	// 	<meta charset="UTF-8">
	// 	<meta name="viewport" content="width=device-width, initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
	// 	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	// 	<link rel="dns-prefetch" href="//'.$domain.'">'.$s3Dns.'
	// 	<link rel="dns-prefetch" href="//www.googletagmanager.com">
	// 	<title>'.$title.'</title>
	// 	<meta name="description" content="'.$description.'">
	// 	<meta name="author" content="'.$author.'">
	// 	<meta name="google" content="notranslate" />
	// 	<link rel="shortcut icon" href="'.$url.'/assets/img/favicon.png">
	// 	<link rel="icon" href="'.$url.'/favicon.ico">
	// 	<link rel="apple-touch-icon" href="'.$url.'/assets/img/favicon.png">
	// 	<link rel="icon" type="image/png" href="'.$url.'/assets/img/favicon.png">
	// 	<link rel="icon" type="image/svg+xml" href="'.$url.'/assets/img/favicon.png">
	// 	<link rel="canonical" href="'.$canonical.'">
	// 	<link rel="alternate" hreflang="'.$lang.'" href="'.$url.rtrim($alt['url'], '/').'">';
	//
	// 	foreach ($alternate as $alt) {
	// 		if(isset($alt['lang'])) {
	// 			$metaTags .= '<link rel="alternate" hreflang="'.$alt['lang'].'" href="'.$url.rtrim($alt['url'], '/').'">';
	// 		}
	// 	}
	// 	if($default !== false) {
	// 		$default = $url.str_replace("//", "/", "/".$default);
	// 		$metaTags .= '<link rel="alternate" hreflang="x-default" href="'.rtrim($default, '/').'" />';
	// 	}
	//
	// 	// Generate Twitter meta tags
	// 	$twitterMetaTags = '
	// 	<meta name="twitter:card" content="summary_large_image">
	// 	<meta name="twitter:title" content="'.$title.'">
	// 	<meta name="twitter:description" content="'.$description.'">
	// 	<meta name="twitter:image" content="'.$image.'">
	// 	<meta name="twitter:url" content="'.$canonical.'">';
	//
	// 	// Generate Open Graph meta tags
	// 	$ogMetaTags = '
	// 	<meta property="og:type" content="website">
	// 	<meta property="og:title" content="'.$title.'">
	// 	<meta property="og:description" content="'.$description.'">
	// 	<meta property="og:image" content="'.$image.'">
	// 	<meta property="og:url" content="'.$canonical.'">';
	//
	// 	// Generate JSON-LD script
	// 	$jsonLd = [
	// 		"@context" => "https://schema.org",
	// 		"@type" => $type,
	// 		"name" => $title,
	// 		"description" => $description,
	// 		"image" => $image,
	// 		"url" => $canonical
	// 	];
	// 	if($local) {
	// 		$jsonLd["address"] = [
	// 			"@type" => "PostalAddress",
	// 			"streetAddress"  => $local["street"],
	// 			"addressLocality"  => $local["city"],
	// 			"addressRegion"  => $local["state"]
	// 		];
	// 		if(!empty($local["postalCode"])) {
	// 			$jsonLd["address"]["postalCode"] = $local["zip"];
	// 		}
	// 		if($local["country"]) {
	// 			$jsonLd["address"]["addressCountry"] = $local["country"];
	// 		}
	// 		if($geo) {
	// 			$jsonLd["geo"] = [
	// 				"@type" => "GeoCoordinates",
	// 				"latitude" => $geo["lat"],
	// 				"longitude" => $geo["long"]
	// 			];
	// 		}
	// 		if($phone) {
	// 			$jsonLd["telephone"] = $phone;
	// 		}
	// 	}
	// 	if(!empty($cat)) {
	// 		$jsonLd["keywords"] = $cat;
	// 	}
	// 	$jsonLdString = json_encode($jsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
	// 	$jsonLdScript = '<script type="application/ld+json">' . $jsonLdString . '</script>';
	//
	// 	// Return combined meta tags and JSON-LD script
	// 	$metaTags .= $twitterMetaTags . $ogMetaTags . $jsonLdScript;
	// 	return trim(preg_replace('/\s+/', ' ', $metaTags));
	// }

	// function metaLink($url,$domain=false) {
	// 	$domain = $domain ?? $_SERVER['HTTP_HOST'];
	// 	if(!str_starts_with('http', $url)) {
	// 		$url = $domain.((str_starts_with('/', $url))? '':'/').$url;
	// 	};
	// 	return htmlspecialchars($url, ENT_QUOTES);
	// }
}
