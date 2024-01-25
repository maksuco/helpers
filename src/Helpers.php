<?php

namespace Maksuco\Helpers;

class Helpers
{
  use Traits\Colors;


	function get_tailwind($config = []) {
		//return 'hola';
		ob_start();
		include __DIR__ ."/Assets/tailwind/tailwind.php";
		$fileContent = ob_get_clean();
		//$fileContent = file_get_contents(__DIR__ ."/Assets/tailwind/tailwind.php");
		file_put_contents('resources/css/tailwind_base.css', $fileContent);
		return $fileContent;
	}
	
	//GET DEVICE AGENT
	function agent($mobile,$tablet,$desktop) {
		if(!isset($_SERVER["HTTP_USER_AGENT"])) {
			return $desktop;
		}
	    $agent = $_SERVER["HTTP_USER_AGENT"];
	    if(preg_match("/(ipad|tablet)/i", $agent)) {
			return $tablet;  
	    } elseif(preg_match("/(android|webos|avantgo|iphone|ipod|blackberry|iemobile|bolt|boost|cricket|docomo|fone|hiptop|mini|opera mini|kitkat|mobi|palm|phone|pie|up\.browser|up\.link|webos|wos)/i", $agent)) {
			return $mobile; 
		}
	  return $desktop;
	}

	//BROWSER, OS
	function user_agent() {
		$data = [];
		$data['tablet'] = $data['mobile'] = $data['desktop'] = $data['estimated'] = false;
		if(!isset($_SERVER["HTTP_USER_AGENT"])) {
			$data['browser'] = 'Chrome';
			$data['os'] = 'Windows';
			$data['result'] = $data['os'].' '.$data['browser'];
			$data['lang'] = 'en';
			$data['estimated'] = true;
			return $data;
		}
		$user_agent = $data['complete'] = $_SERVER["HTTP_USER_AGENT"];
        $data['lang'] = (isset($_SERVER['HTTP_ACCEPT_LANGUAGE']))? substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2) : 'en';
	
		if(preg_match("/(ipad|tablet)/i", $user_agent)) {
			$data['tablet'] = true; $data['device'] = 'tablet';
		} elseif(preg_match("/(android|webos|avantgo|iphone|ipod|blackberry|iemobile|bolt|boost|cricket|docomo|fone|hiptop|mini|opera mini|kitkat|mobi|palm|phone|pie|up\.browser|up\.link|webos|wos)/i", $user_agent)) {
			$data['mobile'] = true; $data['device'] = 'mobile';
		} else {
			$data['desktop'] = true; $data['device'] = 'desktop';
		}
		//Browser
		if (strpos($user_agent, 'Opera') || strpos($user_agent, 'OPR/')) { $data['browser'] = 'Opera'; }
		elseif (strpos($user_agent, 'Googlebot')) { $data['browser'] = 'Googlebot'; }
		elseif (strpos($user_agent, 'Firefox')) { $data['browser'] = 'Firefox'; }
		elseif (strpos($user_agent, 'Edge')) { $data['browser'] = 'Edge'; }
		elseif (strpos($user_agent, 'Chrome')) { $data['browser'] = 'Chrome'; }
		elseif (strpos($user_agent, 'Safari')) { $data['browser'] = 'Safari'; }
		elseif (strpos($user_agent, 'MSIE') || strpos($user_agent, 'Trident/7')) { $data['browser'] = 'Internet Explorer'; }
		else { $data['browser'] = 'Other'; }
			
		//OS
		if (strpos($user_agent, 'Macintosh')) { $data['os'] = 'Macintosh'; }
		elseif (strpos($user_agent, 'iPhone') || strpos($user_agent, 'iOS')) { $data['os'] = 'ios'; }
		elseif (strpos($user_agent, 'CrOS')) { $data['os'] = 'ChromeOS'; }
		elseif (strpos($user_agent, 'Android')) { $data['os'] = 'Android'; }
		elseif (strpos($user_agent, 'Ubuntu')) { $data['os'] = 'Ubuntu'; }
		elseif (strpos($user_agent, 'Linux')) { $data['os'] = 'Linux'; }
		elseif (strpos($user_agent, 'Windows Phone')) { $data['os'] = 'WindowsPhone'; }
		elseif (strpos($user_agent, 'Windows')) { $data['os'] = 'Windows'; }
		else { $data['os'] = 'Other'; }
	
		$data['result'] = $data['os'].' '.$data['browser'];
		return $data;
	}
	
	//GET DEVICE AGENT
	function mobile() {
		if(isset($_SERVER["HTTP_USER_AGENT"])) {
			$agent = $_SERVER["HTTP_USER_AGENT"];
			if(preg_match("/(ipad|tablet)/i", $agent)) {
				return false;  
			} elseif(preg_match("/(android|webos|avantgo|iphone|ipod|blackberry|iemobile|bolt|boost|cricket|docomo|fone|hiptop|mini|opera mini|kitkat|mobi|palm|phone|pie|up\.browser|up\.link|webos|wos)/i", $agent)) {
				return true; 
			}
		}
		return false;
	}

	//CHECK IF VISITOR IS BOT
	function botDetected($user_agent=false) {
		$user_agent = $user_agent ?? $_SERVER['HTTP_USER_AGENT'] ?? false;
    	if($user_agent != false && preg_match('/bot|crawl|slurp|spider|curl|mediapartners/i', $user_agent)) { return true; }
		return false;
	}


	//BROWSER LOCALE
	function browserLocale($languages) {
		$browserLang = (isset($_SERVER["HTTP_ACCEPT_LANGUAGE"]))? substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0,2) : $languages[0];
		if(!in_array($browserLang, $languages)) {
			return $languages[0];  
		}
		return $browserLang;
	}
	
function nav_active($page) {
	if(isset($active)) {
		return ($active == $page)? "active" : "";
	} elseif(request()->route()->getName()) {
		return (request()->route()->getName() == $page)? "active" : "";
	} else {
		return (request()->segments()[0] == $page)? "active" : "";
	}
}

//https://stackoverflow.com/questions/1960461/convert-plain-text-urls-into-html-hyperlinks-in-php
function text_parse($text,$blank=true) {
	//$link_pattern = "/(http|https)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
	//$text = preg_replace($link_pattern, "<a href='\\0' rel='nofollow noopener noreferrer' target='_blank'>\\0</a>", $text);
	$url_pattern = '@(http(s)?)?(://)?(([a-zA-Z])([-\w]+\.)+([^\s\.]+[^\s]*)+[^,.\s])@';
	$blank = ($blank)? 'target="_blank"' : ''; //new
	$text = preg_replace($url_pattern, '<a href="http$2://$4" rel="nofollow noopener noreferrer" '.$blank.' title="$0">$0</a>', $text);
	return $text;
}


function getTextBetween($text, $start="", $end="") {
	$matches = [];
	preg_match_all("/$start([a-zA-Z0-9_]*)$end/", $text, $matches);
	if (empty($matches)) {
		return null;
	}
	return $matches[1];
}


function replaceTextBetween($text, $start="", $end="", $replace=false) {
	$search = '#('.$start.').*?('.$end.')#';
	return preg_replace($search,$replace,$text);
}



function moneyFormat($value,$currency='USD') {
		
	$value = (is_string($value))? (float) $value : $value ?? 0;
	$string = sprintf("%.2f", $value);
	$decimals = (strpos($string,'.00') !== false)? 0 : 2;
	
	if (in_array($currency, ['ARS','BRL','CAD','EUR','ILS','RUB','VND'])) {
		$value = number_format($value, $decimals, '.', ',');
	} else {
		$value = number_format($value, $decimals, ',', '.');
	}
	
	if($currency=='EUR'){ return '€ '.$value;
	} elseif($currency=='BRL') { return 'R$ '.$value;
	} elseif($currency=='CNY') { return '¥ '.$value;
	} elseif($currency=='HKD') { return 'HK$ '.$value;
	} elseif($currency=='INR') { return '₹ '.$value;
	} elseif($currency=='ILS') { return '₪ '.$value;
	} elseif($currency=='JPY') { return '¥ '.$value;
	} elseif($currency=='KRW') { return '₩ '.$value;
	} elseif($currency=='MYR') { return 'RM '.$value;
	} elseif($currency=='MAD') { return $value.' .د.م.';
	} elseif($currency=='PHP') { return '₱ '.$value;
	} elseif($currency=='RUB') { return $value.'₽ ';
	} elseif($currency=='SAR') { return $value.' ﷼';
	} elseif($currency=='ZAR') { return 'R '.$value;
	} elseif($currency=='TWD') { return '元 '.$value;
	} elseif($currency=='THB') { return $value.' ฿';
	} elseif($currency=='TRY') { return $value.' ₺';
	} elseif($currency=='GBP') { return '£ '.$value;
	} elseif($currency=='VND') { return $value.' ₫';
	} else { return '$'.$value;
	}
}


function decimalsFormat($number,$cents=true) {
	//ray('decimalsFormat',$cents);
	if(!$cents){
		return str_replace([".",","," ","$","€","£","¥","₣","₹","₴"],"",$number);
	}
	$number = preg_replace('/\.(?=.*\.)/', '', $number);
	$number = str_replace([","," ","$","€","£","¥","₣","₹","₴"],"",$number);
	$number_parts = explode('.', $number);
	if(count($number_parts) > 1){
	}
	if(isset($number_parts[1])){
		return str_replace(',', '', $number_parts[0]).'.'.substr($number_parts[1], 0, 2);
	} else {
		return str_replace(',', '', $number).'.00';   
	}
}

//returns first name
function firstname($fullname) {
	$fullname = ltrim($fullname," ");
	$nameParts = explode(' ', $fullname);
	if(strlen($nameParts[0]) < 3 AND isset($nameParts[1])) {
		return substr($nameParts[0].' '.$nameParts[1],0,11);
	}
	return substr($nameParts[0],0,11);
}


//returns name initials MM
//https://chrisblackwell.me/generate-perfect-initials-using-php/
function initials(string $fullname) : string {
	$fullname = ltrim($fullname," ");
	$nameParts = explode(' ', $fullname);
	if (count($nameParts) >= 2) {
			return strtoupper(substr($nameParts[0], 0, 1) . substr(end($nameParts), 0, 1));
	}
	preg_match_all('#([A-Z]+)#', $nameParts, $capitals);
	if (count($capitals[1]) >= 2) {
			return substr(implode('', $capitals[1]), 0, 2);
	}
	return strtoupper(substr($nameParts, 0, 2));
}


function geoip($ip,$optional='city',$key=null) {
	if($ip == null){
		$ip = (isset($_SERVER["HTTP_CF_CONNECTING_IP"]))? $_SERVER["HTTP_CF_CONNECTING_IP"] : $_SERVER["REMOTE_ADDR"];
	}
	include_once("Extras/geoip2.php");
	return geoip2($ip,$optional,$key);
}
function geoipLaravel($ip,$optional='city') {
	if($ip == null){
		$ip = (isset($_SERVER["HTTP_CF_CONNECTING_IP"]))? $_SERVER["HTTP_CF_CONNECTING_IP"] : $_SERVER["REMOTE_ADDR"];
	}
	include_once("Extras/geoip2.php");
	return geoip2Laravel($ip,$optional);
}

function timezone($ip,$date) {
	$geo = \Helpers::geoip($ip);
	$timezone = (isset($geo->location->timeZone))? $geo->location->timeZone : 'America/New_York';
	return \Carbon::parse($date)->timezone($timezone)->format("Y-m-d H:m:s");
}

//FIND DISTANCE BETWEEN 2 POINTS
	function distance($lat1, $lon1, $lat2, $lon2, $unit = "M") {

		$theta = $lon1 - $lon2;
		$dist = acos(sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
		$dist = rad2deg($dist);
		$dist = $dist * 60 * 1.1515;
		$unit = strtoupper($unit);
	
		if ($unit == "K") {
			$dist = $dist * 1.609344;
		} else if ($unit == "N") {
			$dist = $dist * 0.8684;
		}
		return round($dist,1);
	}


//APPEND TO JSON (only works with first level)
function appendtojson($json,$new,$subcategory=false,$limit=false) {
	if(!empty($json) OR $json != null){
		$data = json_decode($json,true);
	} else {
		$data = [];
	}
	if(!is_array($new)){
		$new = json_decode($new,true);
	}
	if($subcategory == false){
		array_unshift($data, $new);
		//$data[] = $new;
	} else {
		//$data = json_decode($data[$subcategory],true);
		array_push($data[$subcategory], $new);
		//$data[$subcategory][] = $new;
	}
	if($limit){
		$data = array_slice($data, 0, ($limit -1));
	}
	return json_encode($data);
}


//MODIFY CSV STRING ACTION=ADD,REMOVE,CHECK
function csvstring($action,$data,$new) {
	$data = explode(",",$data);
	$exist = false;
	foreach($data as $value) {
		if($value == $new){ $exist = true; break; }
	}
	if($action == 'add'){
		if($exist) { return true; }
		array_unshift($data, $new);
	} elseif($action == 'remove'){
		if($exist){unset($data[$new]);}
	} else { return $exist; }
	return implode(",",$data);
}

//MODIFY AN ARRAY WITH ACTION=ADD,REMOVE,CHECK, INVERT
//SHOULD WORK WITH Associative ALSO
function array_process($action,$array,$new) {
	//return $array[$new];
	$exist = false;
	//$array = ($array !== null AND is_array($array))? $array : [];
	if($array == null){
		$array = [];
	} elseif(is_string($array) || is_int($array)){
		$implode = true;
		$array = explode(",", $array);
	}
	//IF ASSOCIATIVE
	if(count(array_filter(array_keys($array), 'is_string')) > 0){
		//ACTION
		if($action == 'add'){
			$array = array_merge($array, $new);
		} elseif($action == 'remove'){
			foreach($new as $kew => $value) {
				unset($array[$kew]);
			}
		//INVERT
		} elseif($action == 'invert'){
			//check first
			if(array_key_exists($new,$array)){
				foreach($new as $kew => $value) {
					unset($array[$kew]);
				}
				return "removed";
			} else {
				$array = array_merge($array, $new);
				return "added";
			}
		//CHECK
		} else {
			if(array_key_exists($new,$array)){
				$exist = true;
			}
			return $exist;
		}

	} else {
		//CHECK DUPLICATE
		foreach($array as $value) {
			if($value == $new){ $exist = true; break; }
		}
		//ACTION
		if($action == 'add'){
			if($exist) { return $array; }
			array_unshift($array, $new);
		} elseif($action == 'remove'){
			if($exist){
				foreach (array_keys($array, $new, true) as $key) {
					unset($array[$key]);
				}
			}
		} elseif($action == 'invert'){
			if($exist){
				foreach (array_keys($array, $new, true) as $key) {
					unset($array[$key]);
				}
				return "removed";
			} else {
				array_unshift($array, $new);
				return "added";
			}
		} else {
			return $exist;
		}
	}
	if(isset($implode)){
		return implode(",", $array);
	}
	return $array;
}



function collection_relation($principal,$second,$second_relation_column,$values,$principal_relation_column='id') {
	foreach($principal as $row) {
		//dd($principal);
		foreach($second as $row2) {
				if($row->id == $row2->$second_relation_column) {
					foreach($values as $key => $value) {
						$row->$key = $row2->$value;
					}
				}
		}
	}
	return $principal;
}

function column_check($data,$value) {
	include_once("Extras/column.php");
	return column_check($data,$value);
}

function column_process($data,$table,$column,$value) {
	include_once("Extras/column.php");
	return column_process($data,$table,$column,$value);
}


function countries($lang='en') {
	if($lang == 'es'){
		$data = file_get_contents(__DIR__ ."/Extras/countries_es.json");
	} else {
		$data = file_get_contents(__DIR__ ."/Extras/countries_en.json");
	}
	return json_decode($data);
}

function country($isoCode="US") {
	$data = json_decode(file_get_contents(__DIR__ ."/Extras/countries_en.json"), true);
	$isoCode = strtoupper($isoCode);
	foreach($data as $country){
		if($country['code'] == $isoCode){
			return $country;
		}
	}
	return false;
}
function cities($countryCode="US") {
	include_once("Extras/geoip2.php");
	return storeGeoData();

	$data = json_decode(file_get_contents(__DIR__ ."/Extras/cities.json"));
	$countryCode = strtoupper($countryCode);
	foreach($data[$countryCode] as $city){
		$results[] = $city;
	}
	return $results;
}

function continent($country,$simplify=false) {
	include_once("Extras/geoip2.php");
	$code =  getCountryData($country);
    $code = getTimezone_range($code['continent_code']);
	$code = ($simplify AND $code !== 'europe')? 'america' : $code;
	return $code;
}


function timezones($laravel=false) {
	if($laravel){
		include_once(base_path().'/vendor/maksuco/helpers/src/Extras/timezones.php');
	} else {
		include_once(__DIR__ ."/Extras/timezones.php");
	}
	return $timezones;
}

function languages($lang='all',$laravel=false) {
	if($laravel){
		include(base_path().'/vendor/maksuco/helpers/src/Extras/languages.php');
	} else {
		include(__DIR__ ."/Extras/languages.php");
	}
	if($lang == 'all'){
		return $languages;
	} else {
		return $languages[$lang];
	}
}


function prepareCode($code) {
	$string = str_replace(["<code","</code"], ["xcxoxdxex","-cxoxdxex"], $code);
	$string = str_replace("<", "&lt;", $string);
	return str_replace(["xcxoxdxex","-cxoxdxex"], ["<code","</code"], $string);
}


function currencies($isoCode=null) {
	include(__DIR__ ."/Extras/currencies.php");
	if($isoCode == 'complete') {
		return $currencies;
	} elseif($isoCode != null){
		return $currencies[strtolower($isoCode)];
	}
	return array_keys($currencies);
}


function currency_format($amount, $isoCode, $array = false) {
	include(__DIR__ ."/Extras/currencies.php");
	$currency = $currencies[strtolower($isoCode)];
	//FORMAT AMOUNT
	if (fmod($amount, 1) !== 0.0) {
		//TRUE has decimals
		$decimals = 2;
	} else {
		$amount = $amount + 0; //remove decimals
		$decimals = 0;
	}
	$amount = number_format($amount, $decimals, $currency['decimalSeparator'], $currency['thousandsSeparator']);

	//FORMAT SYMBOL
	if ($currency['symbolFirst']) {
		$result = $currency['symbol'] . $amount;
		$isoCode = ' '.$isoCode;
	} else {
		$result = $amount . $currency['symbol'];
		$isoCode = '';
	}

	//RESULTS
	if($array) {
		$return['result'] = $result;
		$return['symbol'] = $currency['symbol'];
		$return['htmlEntity'] = $currency['htmlEntity'];
		$return['amount'] = $amount;
		$return['isoCode'] = $currency['isoCode'];
		$return['symbolFirst'] = $currency['symbolFirst'];
		$return['decimalSeparator'] = $currency['decimalSeparator'];
		$return['thousandsSeparator'] = $currency['thousandsSeparator'];
	} else {
		$return = $result.$isoCode;
	}
	return $return;
}


function currency_exchange($amount, $from, $to='usd', $round=false) {
	if(!isset($_SESSION['xe_'.$from.'_'.$to])) {
		if(!isset($_SESSION)) { session_start(); };
		$rate = json_decode(file_get_contents('https://v6.exchangerate-api.com/v6/dbbe793672781ae3bea9001a/pair/'.$from.'/'.$to.''), true);
		$_SESSION['xe_'.$from.'_'.$to] = $rate['conversion_rate'] ?? 0;
		//file_put_contents("conversion_rate.txt", $rate['conversion_rate']);
	}
	$return = $amount * $_SESSION['xe_'.$from.'_'.$to];
	if($round) {
		$return = round($return, 0);
	}
	return $return;
}



//should this be in another file? and return continent, language and timezone_range (for emails and console commands)??
function country_continents($countryCode) {
	$COUNTRY_CONTINENTS = ["AF"=>"AS","AX"=>"EU","AL"=>"EU","DZ"=>"AF","AS"=>"OC","AD"=>"EU","AO"=>"AF","AI"=>"NA","AQ"=>"AN","AG"=>"NA","AR"=>"SA","AM"=>"AS","AW"=>"NA","AU"=>"OC","AT"=>"EU","AZ"=>"AS","BS"=>"NA","BH"=>"AS","BD"=>"AS","BB"=>"NA","BY"=>"EU","BE"=>"EU","BZ"=>"NA","BJ"=>"AF","BM"=>"NA","BT"=>"AS","BO"=>"SA","BA"=>"EU","BW"=>"AF","BV"=>"AN","BR"=>"SA","IO"=>"AS","BN"=>"AS","BG"=>"EU","BF"=>"AF","BI"=>"AF","KH"=>"AS","CM"=>"AF","CA"=>"NA","CV"=>"AF","KY"=>"NA","CF"=>"AF","TD"=>"AF","CL"=>"SA","CN"=>"AS","CX"=>"AS","CC"=>"AS","CO"=>"SA","KM"=>"AF","CD"=>"AF","CG"=>"AF","CK"=>"OC","CR"=>"NA","CI"=>"AF","HR"=>"EU","CU"=>"NA","CY"=>"AS","CZ"=>"EU","DK"=>"EU","DJ"=>"AF","DM"=>"NA","DO"=>"NA","EC"=>"SA","EG"=>"AF","SV"=>"NA","GQ"=>"AF","ER"=>"AF","EE"=>"EU","ET"=>"AF","FO"=>"EU","FK"=>"SA","FJ"=>"OC","FI"=>"EU","FR"=>"EU","GF"=>"SA","PF"=>"OC","TF"=>"AN","GA"=>"AF","GM"=>"AF","GE"=>"AS","DE"=>"EU","GH"=>"AF","GI"=>"EU","GR"=>"EU","GL"=>"NA","GD"=>"NA","GP"=>"NA","GU"=>"OC","GT"=>"NA","GG"=>"EU","GN"=>"AF","GW"=>"AF","GY"=>"SA","HT"=>"NA","HM"=>"AN","VA"=>"EU","HN"=>"NA","HK"=>"AS","HU"=>"EU","IS"=>"EU","IN"=>"AS","ID"=>"AS","IR"=>"AS","IQ"=>"AS","IE"=>"EU","IM"=>"EU","IL"=>"AS","IT"=>"EU","JM"=>"NA","JP"=>"AS","JE"=>"EU","JO"=>"AS","KZ"=>"AS","KE"=>"AF","KI"=>"OC","KP"=>"AS","KR"=>"AS","KW"=>"AS","KG"=>"AS","LA"=>"AS","LV"=>"EU","LB"=>"AS","LS"=>"AF","LR"=>"AF","LY"=>"AF","LI"=>"EU","LT"=>"EU","LU"=>"EU","MO"=>"AS","MK"=>"EU","MG"=>"AF","MW"=>"AF","MY"=>"AS","MV"=>"AS","ML"=>"AF","MT"=>"EU","MH"=>"OC","MQ"=>"NA","MR"=>"AF","MU"=>"AF","YT"=>"AF","MX"=>"NA","FM"=>"OC","MD"=>"EU","MC"=>"EU","MN"=>"AS","ME"=>"EU","MS"=>"NA","MA"=>"AF","MZ"=>"AF","MM"=>"AS","NA"=>"AF","NR"=>"OC","NP"=>"AS","AN"=>"NA","NL"=>"EU","NC"=>"OC","NZ"=>"OC","NI"=>"NA","NE"=>"AF","NG"=>"AF","NU"=>"OC","NF"=>"OC","MP"=>"OC","NO"=>"EU","OM"=>"AS","PK"=>"AS","PW"=>"OC","PS"=>"AS","PA"=>"NA","PG"=>"OC","PY"=>"SA","PE"=>"SA","PH"=>"AS","PN"=>"OC","PL"=>"EU","PT"=>"EU","PR"=>"NA","QA"=>"AS","RE"=>"AF","RO"=>"EU","RU"=>"EU","RW"=>"AF","SH"=>"AF","KN"=>"NA","LC"=>"NA","PM"=>"NA","VC"=>"NA","WS"=>"OC","SM"=>"EU","ST"=>"AF","SA"=>"AS","SN"=>"AF","RS"=>"EU","SC"=>"AF","SL"=>"AF","SG"=>"AS","SK"=>"EU","SI"=>"EU","SB"=>"OC","SO"=>"AF","ZA"=>"AF","GS"=>"AN","ES"=>"EU","LK"=>"AS","SD"=>"AF","SR"=>"SA","SJ"=>"EU","SZ"=>"AF","SE"=>"EU","CH"=>"EU","SY"=>"AS","TW"=>"AS","TJ"=>"AS","TZ"=>"AF","TH"=>"AS","TL"=>"AS","TG"=>"AF","TK"=>"OC","TO"=>"OC","TT"=>"NA","TN"=>"AF","TR"=>"AS","TM"=>"AS","TC"=>"NA","TV"=>"OC","UG"=>"AF","UA"=>"EU","AE"=>"AS","GB"=>"EU","UM"=>"OC","US"=>"NA","UY"=>"SA","UZ"=>"AS","VU"=>"OC","VE"=>"SA","VN"=>"AS","VG"=>"NA","VI"=>"NA","WF"=>"OC","EH"=>"AF","YE"=>"AS","ZM"=>"AF","ZW"=>"AF"];
    //lang
    if(in_array($countryCode, ["ES", "AR", "BO", "CL", "CO", "CR", "CU", "CW", "DO", "EC", "HN", "MX", "NI", "PA", "PE", "PR", "PY", "VE", "UY", "GT", "SV"])) {
      $lang = "es";
    } elseif(in_array($countryCode, ["AG","AU","BS","BB","BZ","CA","DO","EN","IE","JM","GD","GY","LC","NZ","TT","UK","US","VC"])) {
      $lang = "en";
    } elseif(in_array($countryCode, ["PT","BR","MZ","AO"])) {
      $lang = "pt";
    } elseif(in_array($countryCode, ["FR","SN"])) {
      $lang = "fr";
    } else {
      $lang = "en";
		}
		return $lang;
}


	function icon($name,$class=false,$extras='') {
		$file = file_get_contents(__DIR__."/Assets/icons/".$name.".svg");
		if($class){
			$file = str_replace('"svg-icon"', '"'.$class.'" '.$extras, $file);
		}
		return $file;
	}

	//missing svg code per icon to show on front
	function icons($name,$action='all') {
		$files = scandir(__DIR__."/Assets/icons/");
		if($action=='all'){
			return $files;
		} else {
			$results = [];
			foreach ($files as $file) {
				if (strpos($action, $file) !== false) {
					$results[] = $file;
				}
			}
			return $results;
		}
	}
	
  //GetAvatar
  function avatar($user,$s3=null) {

		//IF EMPTY
		if(empty($user) OR $user == null) {
			$imagedata = file_get_contents(__DIR__."/Extras/avatars/avatar.png");
			return "data:image/png;base64,".base64_encode($imagedata);
		}
		if(is_array($user)){
			$user = json_decode(json_encode($user), FALSE);
		}
		//IF USER AVATAR
		if(!empty($user->avatar) AND $user->avatar != NULL) {
			//if avatar is facebook or google
			if (strpos($user->avatar, 'http') === 0) {
				return $user->avatar;
			}
			$server = $s3 ?? $user->server_s3 ?? 's3';
			//ray('avatar',$server,$s3,config('app.avatar_path'));
			return \Storage::disk($server)->url(config('app.avatar_path').$user->avatar);
		}
		//IF GRAVATAR
		if(!empty($user->email) AND $user->email != NULL) {
			$gravatar = md5(strtolower(trim($user->email)));
			$gravatar = @file_get_contents("https://s.gravatar.com/avatar/$gravatar?d=404");
			if(!$gravatar){
				$imagedata = file_get_contents(__DIR__."/Extras/avatars/avatar.png");
				return "data:image/png;base64,".base64_encode($imagedata);
			} else {
				return "data:image/png;base64,".base64_encode($gravatar);
				//return "https://s.gravatar.com/avatar/$gravatar";
			}
		}
		//IF SEX
		if(isset($user->sex)) {
			if($user->sex == 'f'){
				$imagedata = file_get_contents(__DIR__."/Extras/avatars/avatar-f.png");
				return "data:image/png;base64,".base64_encode($imagedata);
			} else {
				$imagedata = file_get_contents(__DIR__."/Extras/avatars/avatar-m.png");
				return "data:image/png;base64,".base64_encode($imagedata);
			}
		}
		
		//ALL OTHERS
		// "data:image/png;base64,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",
		$imagedata = file_get_contents(__DIR__."/Extras/avatars/avatar.png");
		return "data:image/png;base64,".base64_encode($imagedata);
  }
	
	//CRYPTO
	function encrypt($string,$key) {
		$CRYPTO_STRING = config('app.crypto_string') ?? config('app.key') ?? '123456789ZYX';
		$iv = substr(hash('sha256', $CRYPTO_STRING), 0, 16);
		$encrypted = openssl_encrypt($string, "AES-256-CBC", $key, 0, $iv);
		$encrypted = strtr($encrypted, "+/", "-_");
	  return $encrypted;
	}
	function decrypt($string,$key) {
		$CRYPTO_STRING = config('app.crypto_string') ?? config('app.key') ?? '123456789ZYX';
		$string = strtr( $string, "-_", "+/");
		$iv = substr(hash('sha256', $CRYPTO_STRING), 0, 16);
		$decrypted = openssl_decrypt($string, "AES-256-CBC", $key, 0, $iv);
	  return $decrypted;
	}
	function lettersToNumbers($string,$phone=false) {
		$replace = ($phone)? '22233344455566677778889999' : '01122233344455556677788899';
		$string = strtr(strtoupper($string), "ABCDEFGHIJKLMNOPQRSTUVWXYZ", $replace);
	  	return $string;
	}

	//GET FILE TYPE
	function getFileType($filename) {
        if ($filename == null) {
            return null;
        }
		$ext = explode(".",$filename)[1];
		if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
            return 'image';
        } elseif (in_array($ext, ['m4v','avi','mp4','mov'])) {
            return 'video';
        } elseif (in_array($ext, ['mp3'])) {
            return 'audio';
        }
        return 'raw';
	}
	
	//FILE SIZES CALCULATOR TO BYTES
	function sizetobytes($size,$reverse=false) {
		//UNITS TO BYTES
		if(!$reverse) {
			$unit = strtolower($size);
			$unit = preg_replace('/[^a-z]/', '', $unit);
			$value = intval(preg_replace('/[^0-9]/', '', $size));
			$units = array('b'=>0, 'kb'=>1, 'mb'=>2, 'gb'=>3, 'tb'=>4);
			$exponent = isset($units[$unit]) ? $units[$unit] : 0;
			return ($value * pow(1024, $exponent));    
		}       
		//BYTES TO UNITS
        if ($size >= 1073741824) {
            $size = number_format($size / 1073741824, 2).' gb';
        } elseif ($size >= 1048576) {
            $size = number_format($size / 1048576, 2).' mb';
        } elseif ($size >= 1024) {
            $size = number_format($size / 1024, 2).' kb';
        } elseif ($size > 1) {
            $size = $size.' bytes';
        } elseif ($size == 1) {
            $size = $size.' byte';
        } else {
            $size = '0 bytes';
        }

        return $size;
	}

	//GET FILENAME FROM STRING/URL
  public function filename($string,$parse=false)
  {
		$string = parse_url($string, PHP_URL_PATH);
		if($parse){
			$path_info = pathinfo($string);
			$data['basename'] = $path_info['basename'];
			$data['extension'] = $path_info['extension'];
			$data['filename'] = $path_info['filename'];
			return (object) $data;
		}
		return basename($string);
	}
	
	function slugReplace(){
	return [
        '&lt;' => '', '&gt;' => '', '&#039;' => '', '&amp;' => '', '&quot;' => '', 'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä'=> 'Ae', '&Auml;' => 'A', 'Å' => 'A', 'Ā' => 'A', 'Ą' => 'A', 'Ă' => 'A', 'Æ' => 'Ae', 'Ç' => 'C', 'Ć' => 'C', 'Č' => 'C', 'Ĉ' => 'C', 'Ċ' => 'C', 'Ď' => 'D', 'Đ' => 'D', 'Ð' => 'D', 'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ē' => 'E', 'Ę' => 'E', 'Ě' => 'E', 'Ĕ' => 'E', 'Ė' => 'E', 'Ĝ' => 'G', 'Ğ' => 'G', 'Ġ' => 'G', 'Ģ' => 'G', 'Ĥ' => 'H', 'Ħ' => 'H', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 'Ī' => 'I', 'Ĩ' => 'I', 'Ĭ' => 'I', 'Į' => 'I', 'İ' => 'I', 'Ĳ' => 'IJ', 'Ĵ' => 'J', 'Ķ' => 'K', 'Ł' => 'K', 'Ľ' => 'K', 'Ĺ' => 'K', 'Ļ' => 'K', 'Ŀ' => 'K', 'Ñ' => 'N', 'Ń' => 'N', 'Ň' => 'N', 'Ņ' => 'N', 'Ŋ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'Oe', '&Ouml;' => 'Oe', 'Ø' => 'O', 'Ō' => 'O', 'Ő' => 'O', 'Ŏ' => 'O', 'Œ' => 'OE', 'Ŕ' => 'R', 'Ř' => 'R', 'Ŗ' => 'R', 'Ś' => 'S', 'Š' => 'S', 'Ş' => 'S', 'Ŝ' => 'S', 'Ș' => 'S', 'Ť' => 'T', 'Ţ' => 'T', 'Ŧ' => 'T', 'Ț' => 'T', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'Ue', 'Ū' => 'U', '&Uuml;' => 'Ue', 'Ů' => 'U', 'Ű' => 'U', 'Ŭ' => 'U', 'Ũ' => 'U', 'Ų' => 'U', 'Ŵ' => 'W', 'Ý' => 'Y', 'Ŷ' => 'Y', 'Ÿ' => 'Y', 'Ź' => 'Z', 'Ž' => 'Z', 'Ż' => 'Z', 'Þ' => 'T', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'ae', '&auml;' => 'ae', 'å' => 'a', 'ā' => 'a', 'ą' => 'a', 'ă' => 'a', 'æ' => 'ae', 'ç' => 'c', 'ć' => 'c', 'č' => 'c', 'ĉ' => 'c', 'ċ' => 'c', 'ď' => 'd', 'đ' => 'd', 'ð' => 'd', 'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ē' => 'e', 'ę' => 'e', 'ě' => 'e', 'ĕ' => 'e', 'ė' => 'e', 'ƒ' => 'f', 'ĝ' => 'g', 'ğ' => 'g', 'ġ' => 'g', 'ģ' => 'g', 'ĥ' => 'h', 'ħ' => 'h', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ī' => 'i', 'ĩ' => 'i', 'ĭ' => 'i', 'į' => 'i', 'ı' => 'i', 'ĳ' => 'ij', 'ĵ' => 'j', 'ķ' => 'k', 'ĸ' => 'k', 'ł' => 'l', 'ľ' => 'l', 'ĺ' => 'l', 'ļ' => 'l', 'ŀ' => 'l', 'ñ' => 'n', 'ń' => 'n', 'ň' => 'n', 'ņ' => 'n', 'ŉ' => 'n', 'ŋ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'oe', '&ouml;' => 'oe', 'ø' => 'o', 'ō' => 'o', 'ő' => 'o', 'ŏ' => 'o', 'œ' => 'oe', 'ŕ' => 'r', 'ř' => 'r', 'ŗ' => 'r', 'š' => 's', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'ue', 'ū' => 'u', '&uuml;' => 'ue', 'ů' => 'u', 'ű' => 'u', 'ŭ' => 'u', 'ũ' => 'u', 'ų' => 'u', 'ŵ' => 'w', 'ý' => 'y', 'ÿ' => 'y', 'ŷ' => 'y', 'ž' => 'z', 'ż' => 'z', 'ź' => 'z', 'þ' => 't', 'ß' => 'ss', 'ſ' => 'ss', 'ый' => 'iy', 'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'YO', 'Ж' => 'ZH', 'З' => 'Z', 'И' => 'I', 'Й' => 'Y', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O', 'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C', 'Ч' => 'CH', 'Ш' => 'SH', 'Щ' => 'SCH', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'YU', 'Я' => 'YA', 'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh', 'з' => 'z', 'и' => 'i', 'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c', 'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sch', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu', 'я' => 'ya', '.' => '', '"' => '', "'" => ''
     ];
  }
  //Slug helper
  public function slug($data,$div='-')
  {
		$replace = $this->slugReplace();
		$data = strtr($data, $replace);
		$data = preg_replace('~[^\\pL\d.]+~u', $div, $data);
		$data = trim($data, '-');
		$data = preg_replace('~[^-\w.]+~', '', $data);
		return strtolower($data);
  }
  //returns new filename
  function slug_file($filename,$random) {
    $data = pathinfo($filename); //explode('.', $filename);
	$filename = substr($data['filename'],0,60);
    $result = $this->slug($filename).$this->slug_random($random).'.'.$data['extension'];
    return strtolower($result);
  }
  //returns filename with a name you specify
  function slug_filename($filename,$name,$random) {
    $data = pathinfo($filename);
    $result = $this->slug($name).$this->slug_random($random).'.'.$data['extension'];
    return strtolower($result);
	}

	function slug_username($string) {
		$replace = $this->slugReplace();
		$string = strtr($string, $replace);
		$string = preg_replace('~[^-\w.]+~', '', $string);
		return strtolower(trim($string));
	}
	
  //Adds random at the end of the file name, and checks if its numeric or string
  function slug_random($characters) {
    if (is_numeric($characters)) {
      if($characters) {
        return '-'.$this->random($characters);
      } else {
        return '';
      }
    }
    return '-'.$characters;
	}
	
	//Because str_random doesn't work anymore
  function random($characters = 1,$numbers = null) {
		if($numbers == null) {
			$chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
		} elseif($numbers){
			$chars = '0123456789';
		} else {
			$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
		}
		$chars = ($numbers)? '0123456789' : '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
		$count = strlen($chars);
		$bytes = random_bytes((int) $characters);
		$random = '';
		foreach (str_split($bytes) as $byte) {
				$random .= $chars[ord($byte) % $count];
		}
		return $random;
	}
	
	//Because str_random doesn't work anymore
  function random_name($type=null) {
		$names = ['Allison','Arthur','Arnold','Ana','Alex','Alberto','Barry','Bertha','Bill','Bonnie','Brian','Charlie','Charley','Cindy','Chris','Dean','Dolly','Danny','Danielle','Dennis','Debby','Erin','Eduard','Erika','Earl','Emily','Ernesto','Felix','Fay','Fabian','Frances','Franklin','Florence','Gustav','Grace','Gaston','Gert','Gordon','Humberto','Hanna','Harrison','Henry','Hermine','Harvey','Helene','Iris','Isidore','Isabel','Ivan','Ines','Irene','Isaac','Jerry','Josephine','Juan','Jeanne','John','Jose','Joyce','Karen','Kyle','Kate','Karl','Katrina','Kirk','Lorenzo','Lili','Larry','Lisa','Lee','Leslie','Michelle','Marco','Mindy','Maria','Michael','Noel','Nana','Nicholas','Nicole','Nate','Nadine','Ned','Olga','Omar','Odette','Otto','Ophelia','Oscar','Pablo','Paloma','Peter','Paul','Paula','Philippe','Patty','Rebekah','Rene','Rose','Richard','Rita','Rafael','Robert','Sally','Sam','Stan','Sandy','Steve','Tanya','Teddy','Teresa','Tomas','Tammy','Tony','Van','Vicky','Victor','Vince','Valerie','Wendy','Wilfred','Will','Wanda','Walter','Wilma','William','Vision'];
		shuffle($names);
		if($type == 'name') {
			return $names[0];
		}
		$lastNames = ['Abbott','Acosta','Adams','Armstrong','Bates','Baratheon','Buchanan','Campbell','Cash','Chan','Conrad','Cook','Copeland','Davidson','De Niro','DiCaprio','Dickson','Downey Jr.','Farmer','Fischer','Fonda','Ford','Epstein','Garcia','Gates','Garland','Gekko','Hamilton','Hoover','Jobs','Khan','Knight','Koch','Lancaster','Lannister','Lennon','Li','Liu','StarLord','Macdonald','McCartney','McSwain','Ming','Norris','Oneal','Osborn','Payne','Preston','Quill','Robles','Rojas','Romanoff','Schwarzenegger','Smith','Snow','Stanley','Stark','Targaryen','Thanos','Terminator','Turner','Vision','Walton','Wayne','Wozniak','Zimmerman'];
		shuffle($lastNames);
		if($type == 'lastname') {
			return $lastNames[0];
		}
		return $names[0].' '.$lastNames[0];
	}

	function hide_string($string, $middle = '****',$position=false) {
		if($position == 'start') {
			return substr($string, 0, 4).$middle;
		} elseif($position == 'end') {
			return $middle.substr($string, -4);
		}
		return substr($string, 0, 4).$middle.substr($string, -4);
	}

	function random_quote() {
		$quotes = json_decode(file_get_contents('Extras/quotes.json'),true);
		shuffle($quotes);
		return $quotes[0];
	}
	
	//Because str_random doesn't work anymore
  function greetings_by_time($timezone=false) {
		if($timezone){
			date_default_timezone_set($timezone);
		}
    $hour = date("H");
    if ($hour < "12") {
			return "Good morning";
    } elseif ($hour >= "12" && $hour < "17") {
			return "Good afternoon";
    } elseif ($hour >= "17" && $hour < "19") {
			return "Good evening";
    }
		return "Good night";
	}

	//returns today, tomorrow, yesterday
	function date_day($date_or_day,$lang='en') {
		if(!is_string($date_or_day) OR !is_numeric($date_or_day)) {
			//convert date to days difference
		}
		if($date_or_day == 0) {
			return ($lang=='en')? "today" : "hoy";
		} elseif($date_or_day == -1) {
			return ($lang=='en')? "yesterday" : "ayer";
		} elseif($date_or_day == 1) {
			return ($lang=='en')? "tomorrow" : "mañana";
		} elseif($date_or_day < 0) {
			if($lang=='en') {
				return abs($date_or_day)." days ago";
			} else {
				return "hace ".abs($date_or_day)." días";
			}
		} else {
			if($lang=='en') {
				return "in ".$date_or_day." days";
			} else {
				return "en ".$date_or_day." días";
			}
		}
	}



//CHECK if url has http
function telto($phone) {
	return str_replace(['+', '(', ')', '-', ' '], '', $phone);
}



//CHECK video ID from string
function getVideoID($provider,$string) {
	if($provider == 'link' OR strpos($string, 'http') !== false) {
	} else {
		return $string;
	}
	if($provider == 'youtube') {
		preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $string, $matches);
		return $matches[1];
	} elseif($provider == 'vimeo') {
		return (int) substr(parse_url($string, PHP_URL_PATH), 1);
	}
	return $string;
}

//CHECK if url has http
function link($url) {
	if (str_starts_with($url, 'https:') || str_starts_with($url, 'http:') || str_starts_with($url, 'tel') || str_starts_with($url, 'mail') || str_starts_with($url, 'sms')) {
	} elseif (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
		$url = "https://" . $url;
	}
	return str_replace(' ', '', $url);
}

//CHECK if email domain exist.
function email_check($email) {
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		return false; 
	}
	$domain = explode("@",$email);
	if (!checkdnsrr($domain[1], 'MX')) {
		return false; 
	}
	return true;
}

//CHECK if domain exist.
function domain_check($domain) {

	$domain =  str_replace(["https://","http://"],"",$domain);
	$check = dns_get_record($domain);
	return (count($check) > 0) ? true : false;

	// return (!empty(@file_get_contents($domain)))? true : false;

	// $domain = parse_url($domain);
	// if(!empty($domain['host'])) { return false;}
	// $check = checkdnsrr($domain['host'], "A");
	// return (!empty($check))? true : false;

	// $domain = (strpos($value, '@') !== false)? substr(strrchr($value, "@"), 1) : $value;
	// if($domain) {
	// 	//$handle = dns_get_record($url);
    // 	$check = checkdnsrr($domain, "A");
	// 	return (!empty($check))? true : false;
	// }
	// return false;
}

function url_html($url,$section='body',$replace_url=false) {
	//$html = \Illuminate\Support\Facades\Http::get($url)->body();
	$html = @file_get_contents($url);
	if(empty($html) || $html === FALSE){ return ""; }
	$dom = new \DOMDocument();
	libxml_use_internal_errors(true);
	$dom->loadHTML($html);
	//check images url full path
	if($replace_url){
		$urlParts = parse_url($url);
		$urlDomain = $urlParts['scheme'].'://'.$urlParts['host'];
		$images = $dom->getElementsByTagName('img');
		foreach ($images as $image) {
			$src = $image->getAttribute('src');
			if(!str_starts_with($src, "https://")) {
				$image->setAttribute('src', $urlDomain.$src);
			}
		}
		$links = $dom->getElementsByTagName('a');
		foreach ($links as $link) {
			$href = $link->getAttribute('href');
			if(!str_starts_with($href, "https://")) {
				$link->setAttribute('href', $urlDomain.$href);
			}
		}
	}
	//get content
	$content = '';
	ray('start',$section);
	if(str_starts_with($section, "#")) {
		$section = ltrim($section, '#');
		$element = $dom->getElementById($section);
		$content = $dom->saveHTML($element);
		ray($section,$element,$content);
	} else {
		$body = $dom->getElementsByTagName($section)->item(0);
		if(!empty($body->childNodes)){
			foreach ($body->childNodes as $node) {
				$content .= $dom->saveHTML($node);
			}
		}
	}
	return $content;
}

function domain_from_url($url,$subdomain=false) {
	$parseUrl = parse_url(trim($url));
	if(isset($parseUrl['host'])) {
	  $trimUrl = $parseUrl['host'];
	} else {
	  $trimUrl = explode('/', $parseUrl['path'])[0];
	}
	if($subdomain) { return $trimUrl; }
	$trimUrl = array_reverse(explode('.', $trimUrl));
	return $trimUrl[1].'.'.$trimUrl[0];
}

function domain_from_email($email) {
  $website = explode('@', $email);
  $website = end($website);
	if(in_array($website,[
		/* Default domains */
		"aol.com", "att.net", "comcast.net", "facebook.com", "gmail.com", "gmx.com", "googlemail.com",
		"google.com", "hotmail.com", "hotmail.co.uk", "mac.com", "me.com", "mail.com", "msn.com",
		"live.com", "sbcglobal.net", "verizon.net", "yahoo.com", "yahoo.co.uk", "lycos.com",
		/* Global domains */
		"email.com", "fastmail.fm", "games.com", "gmx.net", "hush.com", "hushmail.com", "icloud.com",
		"iname.com", "inbox.com", "lavabit.com", "love.com", "outlook.com", "pobox.com", "protonmail.com",
		"rocketmail.com", "safe-mail.net", "wow.com", "ygm.com",
		"ymail.com", "zoho.com", "yandex.com",
		/* United States */
		"bellsouth.net", "charter.net", "cox.net", "earthlink.net", "juno.com",
		/* British */
		"btinternet.com", "virginmedia.com", "blueyonder.co.uk", "freeserve.co.uk", "live.co.uk",
		"ntlworld.com", "o2.co.uk", "orange.net", "sky.com", "talktalk.co.uk", "tiscali.co.uk",
		"virgin.net", "wanadoo.co.uk", "bt.com",
		/* Domains used in Asia */
		"sina.com", "sina.cn", "qq.com", "naver.com", "hanmail.net", "daum.net", "nate.com", "yahoo.co.jp", "yahoo.co.kr", "yahoo.co.id", "yahoo.co.in", "yahoo.com.sg", "yahoo.com.ph", "163.com", "126.com", "aliyun.com", "foxmail.com",
		/* French */
		"hotmail.fr", "live.fr", "laposte.net", "yahoo.fr", "wanadoo.fr", "orange.fr", "gmx.fr", "sfr.fr", "neuf.fr", "free.fr",
		/* German */
		"gmx.de", "hotmail.de", "live.de", "online.de", "t-online.de", "web.de", "yahoo.de",
		/* Italian */
		"libero.it", "virgilio.it", "hotmail.it", "aol.it", "tiscali.it", "alice.it", "live.it", "yahoo.it", "email.it", "tin.it", "poste.it", "teletu.it",
		/* Russian */
		"mail.ru", "rambler.ru", "yandex.ru", "ya.ru", "list.ru",
		/* Belgian */
		"hotmail.be", "live.be", "skynet.be", "voo.be", "tvcablenet.be", "telenet.be",
		/* Argentinian */
		"hotmail.com.ar", "live.com.ar", "yahoo.com.ar", "fibertel.com.ar", "speedy.com.ar", "arnet.com.ar",
		/* Domains used in Mexico */
		"yahoo.com.mx", "live.com.mx", "hotmail.es", "hotmail.com.mx", "prodigy.net.mx",
		/* Domains used in Brazil */
		"yahoo.com.br", "hotmail.com.br", "outlook.com.br", "uol.com.br", "bol.com.br", "terra.com.br", "ig.com.br", "itelefonica.com.br", "r7.com", "zipmail.com.br", "globo.com", "globomail.com", "oi.com.br",
		/* Domains used in India */
		"care2.com", "yahoo.co.in"
	])) {
		return false;
	}
	return $website;
}

//VEE-VALIDATE HONEYPOT
function VeeValidateHoneypot() {
	$random = rand();
return <<<HTML
<div class="d-none" style="display: none;">
	<label>name</label>
	<input type="text" class="form-control" placeholder="name_{$random}" name="name_{$random}" v-validate="'max:0'">
	<input type="text" autcomplete="false" placeholder="city_country_{$random}" name="city_country_{$random}" v-validate="'max:0'" style="opacity: 0;">
	<input type="email" autcomplete="false" placeholder="email_{$random}" name="email_{$random}" v-validate="'max:0'" style="height: 0px; width: 0px; border:none; opacity: 0;">
</div>
HTML;
}

function VeeValidateHoneypotCSS() {
	$random = rand();
return <<<HTML
<style>
	.form-control-invalid {
		//border-color: #dc3545;
		padding-right: calc(1.5em + .75rem);
		background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='%23dc3545' class="svg-icon" viewBox='-2 -2 7 7'%3e%3cpath stroke='%23dc3545' d='M0 0l3 3m0-3L0 3'/%3e%3ccircle r='.5'/%3e%3ccircle cx='3' r='.5'/%3e%3ccircle cy='3' r='.5'/%3e%3ccircle cx='3' cy='3' r='.5'/%3e%3c/svg%3E");
		background-repeat: no-repeat;
		background-position: center right calc(.375em + .1875rem);
		background-size: calc(.75em + .375rem) calc(.75em + .375rem);
	}
</style>
HTML;
}
  
  //analytics
  
	function period($period,$period2) {
	    if($period == 'month') {
	        $startDate = Carbon::now()->subMonth($period2)->startOfMonth();
	        $endDate = Carbon::now()->subMonth($period2)->endOfMonth();
	        if($period2 == 0) {
	        	$startDate = Carbon::now()->startOfMonth();
	        	$endDate = Carbon::now();
	        }
	    } elseif($period == 'year') {
	        $startDate = Carbon::now()->subYear($period2)->startOfYear();
	        $endDate = Carbon::now()->subYear($period2)->endOfYear();
	        if($period2 == 0) {
	        	$startDate = Carbon::now()->startOfYear();
	        	$endDate = Carbon::now();
	        }
	    } elseif($period == 'day') {
	        $startDate = Carbon::now()->subDay($period2);
	        $endDate = Carbon::now();
		} elseif($period == 'all') {
	        $startDate = Carbon::now()->subYear($period2)->startOfYear();
	        $endDate = Carbon::now();
		} else {
	    	$startDate = Carbon::createFromFormat('Y-m-d', $period);
			$endDate = Carbon::createFromFormat('Y-m-d', $period2);
		}
	    return [$startDate,$endDate];
	}
	
	function counter($period,$period2,$path) {
		
	    	$periods = period($period,$period2);
		    $metrics = 'ga:visits,ga:pageviews';
		    
			if(!empty($path)) {
				$analytics = Analytics::performQuery(Spatie\Analytics\Period::create($periods[0], $periods[1]), $metrics, $others = ['filters' => 'ga:pagePath=~/'.$path, 'dimensions' => 'ga:pagePath']);
				//dd($analytics);
				//SUMAR las distintas rows
				$visitors = 0; $pageviews = 0;
				foreach($analytics->rows as $row) {
					$visitors = $visitors + $row[1];
					$pageviews = $pageviews + $row[2];
				}
			} else {
				$analytics = Analytics::fetchVisitorsAndPageViews(Spatie\Analytics\Period::create($periods[0], $periods[1]));
				$visitors = $analytics->sum('visitors');
				$pageviews = $analytics->sum('pageViews');
			}
			
	    return [$visitors,$pageviews];
	}

	//SOCIAL SHARING
	
	function facebookshare($url,$title,$app_id=null) {
		$url = ($url)? $url : (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$return = 'https://www.facebook.com/sharer/sharer.php?u='.$url.'&t='.rawurlencode($title).'&app_id='.$app_id;
		return $return;
	}
	function twittershare($url,$title,$username=null) {
		$url = ($url)? $url : (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$return = 'https://www.twitter.com/intent/tweet?url='.$url.'&text='.rawurlencode($title).'&via='.$username;
		return $return;
	}
	function linkedinshare($url,$title,$username=null) {
		$url = ($url)? $url : (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$return = 'https://www.linkedin.com/shareArticle?url='.$url.'&title='.rawurlencode($title).'&source='.$username;
		return $return;
	}
	function pinterestshare($url,$title,$image=null) {
		$url = ($url)? $url : (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$return = 'https://pinterest.com/pin/create/button/?url='.$url.'&description='.rawurlencode($title).'&media='.$image;
		return $return;
	}
	function whatsappshare($url,$text=false) {
		$url = ($url)? $url : (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$text = ($text)? $text.' ' : '';
		if($this->mobile()){
			$return = 'whatsapp://send?text='.rawurlencode($text).$url;
		} else {
			$return = 'https://wa.me/send?text='.rawurlencode($text).$url;
		}
		return $return;
	}
	function whatsappchat($phone,$url,$text=false) {
		$text = ($text)? $text.' ' : '';
		$phone = str_replace([' ','-','(',')'], '', $phone);
		$url = ($url AND !empty($url))? $url : (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$return = 'https://wa.me/'.$phone.'?text='.rawurlencode($text).$url;
		return $return;
	}
	function popup() {
		//onclick="return popup(this);"
		//top=100,left=100
		return '
			function popup(obj) {
				let url = obj.getAttribute("href");
				let params = "scrollbars=no,resizable=no,status=no,location=no,toolbar=no,menubar=no,width=400,height=500";
				var popup_window = open(url, "Share", params);
				try {
					popup_window.focus();   
				} catch (e) {
					window.open(url, "_blank");
				}
				return false;
			}
		';
	}

	function currenturl() {
		return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	}

	
	//RETURNS DATA FILTERED BY USER
	function dashboard($data) {
		$month = $data->filter(function($user){ return $user->created_at->format('m-y') == date('m-y'); });
		$lastmonth = $data->filter(function($user){ return $user->created_at->format('m-y') == Carbon::now()->firstOfMonth()->subMonth()->format('m-y'); });
		$year = $data->filter(function($user){ return $user->created_at->format('y') == date('y'); });
		$lastyear = $data->filter(function($user){ return $user->created_at->format('y') == Carbon::now()->subYear()->format('y'); });
	
		$results = collect([
				'month' => $month->count(),
				'lastmonth' => $lastmonth->count(),
				'year' => $year->count(),
				'lastyear' => $lastyear->count(),
				'total' => $data->count(),
			]);
			if(isset($data[0]['amount'])) {
				$results = $results->union([
					'month_sum' => $month->sum('amount'),
					'lastmonth_sum' => $lastmonth->sum('amount'),
					'year_sum' => $year->sum('amount'),
					'lastyear_sum' => $lastyear->sum('amount'),
					'total_sum' => $data->sum('amount'),
				]);
			};
	    return $results;
	}
	
	
	function chart($period,$period2,$path) {
		
	    	$periods = period($period,$period2);
		    $metrics = 'ga:visits,ga:pageviews';
		    
			if(!empty($path)) {
				$analytics = Analytics::performQuery(Spatie\Analytics\Period::create($periods[0], $periods[1]), $metrics, $others = ['filters' => 'ga:pagePath=~/'.$path, 'dimensions' => 'ga:pagePath']);
				$visitors = 0; $pageviews = 0;
				foreach($analytics->rows as $row) {
					$visitors = $visitors + $row[1];
					$pageviews = $pageviews + $row[2];
				}
			} else {
				$analytics = Analytics::fetchVisitorsAndPageViews(Spatie\Analytics\Period::create($periods[0], $periods[1]));
				$visitors = $analytics->pluck('visitors');
				$pageviews = $analytics->pluck('pageViews');
				$dates = $analytics->pluck('date');
			}
			foreach($dates as $date) {
				$labels[] = $date->format('d-m-Y');
			}
			
	        $labels = collect($labels);
			
	    return [$visitors,$pageviews,$labels];
	}
	
	//RETURNS CHART DATA FOR CLIENTS data1 and data2
	function charts($data1) {
	    $startDate = Carbon::now()->subDay(365);
	    $endDate = Carbon::now();
	
		//THIS RETURNS THE 4 BOXES
		$month = $data->filter(function($data1){ return $data1->created_at->format('m-y') == date('m-y'); });
		$lastmonth = $data->filter(function($data1){ return $data1->created_at->format('m-y') == Carbon::now()->firstOfMonth()->subMonth()->format('m-y'); });
		$year = $data->filter(function($data1){ return $data1->created_at->format('y') == date('y'); });
		$lastyear = $data->filter(function($data1){ return $data1->created_at->format('y') == Carbon::now()->subYear()->format('y'); });
	
	}
	
	//I think is better to cretae a reports_total and divide this and also implement in invoices.blade
	function reports($biz_id,$table,$date,$sum) {
	
		$results = [];
		$resultsDB = \DB::table($table)->where('biz_id', $biz_id);

		if(isset($_GET['client_id']) AND $_GET['client_id'] != 'all' AND $table != 'clients') {
			$resultsDB->where('client_id', $_GET['client_id']);
		}
		
		if(isset($_GET['currency'])) {
			$resultsDB->where('currency', $_GET['currency']);
		}

		$month = clone $resultsDB;
		$lastmonth = clone $resultsDB;
		$lastmonth2 = clone $resultsDB;
		$lastyear = clone $resultsDB;
		$year = clone $resultsDB;
		$dates_filtered = clone $resultsDB;

		if(!empty($_GET['date_from'])) {
			$dates_filtered->whereDate($date, '>', $_GET['date_from']);
		}
		if(!empty($_GET['date_to'])) {
			$dates_filtered->whereDate($date, '<', $_GET['date_to']);
		}
		$results['results'] = $dates_filtered->count();
		$results['results_sum'] = $dates_filtered->sum($sum);

		$month = $month->whereMonth($date, \Carbon::now()->format('m'));
		$lastmonth = $lastmonth->whereMonth($date, \Carbon::now()->firstOfMonth()->subMonth()->format('m'));
		$lastmonth2 = $lastmonth2->whereMonth($date, \Carbon::now()->firstOfMonth()->subMonth(2)->format('m'));
		$year = $year->whereYear($date, \Carbon::now()->format('Y'));
		$lastyear = $lastyear->whereYear($date, \Carbon::now()->subYear()->format('Y'));

		$results['month'] = $month->count();
		$results['month_sum'] = $month->sum($sum);
		$results['lastmonth'] = $lastmonth->count();
		$results['lastmonth_sum'] = $lastmonth->sum($sum);
		$results['lastmonth2'] = $lastmonth2->count();
		$results['lastmonth2_sum'] = $lastmonth2->sum($sum);
		$results['year'] = $year->count();
		$results['year_sum'] = $year->sum($sum);
		$results['lastyear'] = $lastyear->count();
		$results['lastyear_sum'] = $lastyear->sum($sum);
		$results['total'] = $resultsDB->count();
		$results['total_sum'] = $resultsDB->sum($sum);
		
    	return $results;
	}

	function reports_chart($resultsDB,$date,$sum,$sum2) {
		
		$results = [];
		$data = $resultsDB->select(\DB::raw($date.' as date'), \DB::raw('sum('.$sum.') as total'), \DB::raw('sum('.$sum2.') as sum2'), \DB::raw('count(id) as count'))->groupBy(\DB::raw($date))->get();
		$results['total_sum'] = $data->sum('total');
		$results['total_count'] = $data->sum('count');
		$results['date'] = $data->pluck('date');
		$results['sum'] = $data->pluck('total');
		$results['sum2'] = $data->pluck('sum2');
		$results['count'] = $data->pluck('count');
		return $results;
	}

	function minify_html($html) {
		$search = [
			'/(\n|^)(\x20+|\t)/',
			'/(\n|^)\/\/(.*?)(\n|$)/',
			'/\n/',
			'/\<\!--.*?-->/',
			'/(\x20+|\t)/', # Delete multispace (Without \n)
			'/\>\s+\</', # strip whitespaces between tags
			'/(\"|\')\s+\>/', # strip whitespaces between quotation ("') and end tags
			'/=\s+(\"|\')/' # strip whitespaces between = "'
		];

		$replace = [
			"\n",
			"\n",
			" ",
			"",
			" ",
			"><",
			"$1>",
			"=$1"
		];

		$html = preg_replace($search,$replace,$html);
		return $html;
	}



	//PROCESS INSTAGRAM SCRAPER - OLD VERSION SEE WEBCMS
	function instagram_process($instagram,$username) {
		
		$media = $instagram->getMedias($username,40);
		$object = [];
		foreach ($media as $key => $photo) {
				$object[$key]['id'] = $photo['id'];
				$object[$key]['type'] = $photo['type'];
				$object[$key]['imageThumbnailUrl'] = $photo['imageThumbnailUrl'];
				$object[$key]['imageHighResolutionUrl'] = $photo['imageHighResolutionUrl'];
				$object[$key]['caption'] = $photo['caption'];
				$object[$key]['link'] = $photo['link'];
				$object[$key]['createdTime'] = $photo['createdTime'];
				$object[$key]['likesCount'] = $photo['likesCount'];
				$object[$key]['commentsCount'] = $photo['commentsCount'];
				if ($photo['type'] == "video") {
						$link = $photo->getLink();
						$json_media_by_url = $instagram->getMediaByUrl($link);
						$object[$key]['video_url'] =
								$json_media_by_url['videoStandardResolutionUrl'];
				} elseif ($photo['type'] == "sidecar") {
						$link = $photo->getLink();
						$json_media_by_url = $instagram->getMediaByUrl($link);
						foreach ($json_media_by_url['sidecarMedias'] as $key2 => $photo2) {
								$object[$key]['sidecarMedias'][$key2]['id'] = $photo2['imageLowResolutionUrl'];
								$object[$key]['sidecarMedias'][$key2]['imageLowResolutionUrl'] = $photo2['imageLowResolutionUrl'];
								$object[$key]['sidecarMedias'][$key2]['imageHighResolutionUrl'] = $photo2['imageHighResolutionUrl'];
								$object[$key]['sidecarMedias'][$key2]['link'] = $photo2['link'];
								$object[$key]['sidecarMedias'][$key2]['caption'] = $photo2['caption'];
						}
				}
		}
		return $object;
	}

	function getTikTok($username,$type='profile') {
		if($type == 'profile') {
			$data = json_decode(file_get_contents('https://www.tiktok.com/oembed?url=https://www.tiktok.com/@'.$username));
		} else {
			$data = json_decode(file_get_contents('https://www.tiktok.com/oembed?url=https://www.tiktok.com/@'.$username.'/video/'.$action));
		}
		return $data;
	}
	
}
