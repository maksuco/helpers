<?php
namespace Maksuco\Helpers\Traits;

trait Metatags {

	function metatags($meta, $currentLang, $langs): string
	{
    	$meta = json_decode(json_encode($meta), true);
		$domain = $meta['domain'] ?? config('app.url') ?? ''; // Full URL https://maksuco.com
		$url = rtrim($domain, '/');
		$mainLang = current($langs);

		$title = trim(substr($meta['title'] ?? $meta['metatags']['title'][$currentLang] ?? '', 0, 60));
		$description = substr($meta['description'] ?? $meta['metatags']['description'][$currentLang] ?? '', 0, 160);
		//$keywords = substr($meta['keywords'] ?? $meta['metatags']['keywords'][$currentLang] ?? '', 0, 160);
		$image = $meta['image'] ?? '';
		$author = 'Maksuco.com';
		$type = $meta['type'] ?? 'WebPage';

		$domainHost = parse_url($url)['host'] ?? '';
		$imageHost = !empty($image) ? (parse_url($image)['host'] ?? '') : '';
		$s3Dns = ($imageHost && $imageHost !== $domainHost) ? '<link rel="dns-prefetch" href="//'.$imageHost.'">' : "";
		$robot = empty($meta['noindex'])? 'index, follow' : 'noindex, nofollow';

		$metaTags = '
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<meta name="robots" content="'.$robot.'">
		<link rel="dns-prefetch" href="//'.$domainHost.'">'.$s3Dns.'
		<title>'.$title.'</title>
		<meta name="description" content="'.$description.'">
		<meta name="author" content="'.$author.'">
		<meta name="google" content="notranslate">
		<link rel="shortcut icon" href="'.$url.'/assets/favicon/favicon.png">
		<link rel="icon" href="'.$url.'/favicon.ico">
		<link rel="apple-touch-icon" href="'.$url.'/assets/favicon/apple-touch-icon.png">
  	  	<link rel="icon" type="image/x-icon" href="/assets/favicon/favicon.png">
		<link rel="icon" type="image/png" href="'.$url.'/assets/favicon/favicon.png">
		<link rel="icon" type="image/svg+xml" href="'.$url.'/assets/favicon/favicon.svg">';

		$prepent = $meta['slugsPrepend'] ?? []; //sample 'en'=>'services/'
		//\Debugbar::info('Metatags.php debug',$currentLang);
		if(!empty($meta['slugs'])) {
			$canonical = rtrim($url.'/'.($meta['canonical'] ?? (($prepent[$currentLang] ?? '').$meta['slugs'][$currentLang])), '/');
			if(count($langs) > 1){
				$default = $url.'/'.($prepent[$mainLang] ?? '').$meta['slugs'][$mainLang];
				$metaTags .= '<link rel="alternate" hreflang="x-default" href="'.$default.'"/>';
				foreach($langs as $langKey){
					$altUrl = $url.'/'.($prepent[$langKey] ?? '').$meta['slugs'][$langKey];
					$metaTags .= '<link rel="alternate" hreflang="'.$langKey.'" href="'.rtrim($altUrl, '/').'">';
				}
			}
		} else {
			$canonical = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		}
		$metaTags .= '<link rel="canonical" href="'.$canonical.'">';

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
			"name" => ucfirst($meta['name'] ??config('app.name') ?? str_replace("www.", "", parse_url($url, PHP_URL_HOST))),
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
		}
		if(!empty($meta["jsExtras"])) {
			$jsonLd = array_merge($jsonLd, $meta["jsExtras"]);
		}
		if(!empty($meta["phone"])) {
			$jsonLd["telephone"] = (string) $meta["phone"];
		}
		$jsonLdString = json_encode($jsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
		$jsonLdScript = '<script type="application/ld+json">'.$jsonLdString.'</script>';

		$metaTags .= $twitterMetaTags . $ogMetaTags . $jsonLdScript;
		return trim(preg_replace('/\s+/', ' ', $metaTags));
	}

}
