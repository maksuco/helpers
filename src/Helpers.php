<?php

namespace Maksuco\Helpers;

use function GuzzleHttp\json_decode;

class Helpers
{
	
	//GET DEVICE AGENT
	function agent($mobile,$tablet,$desktop) {
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
		$user_agent = $_SERVER["HTTP_USER_AGENT"];
		$data = [];
		$data['tablet'] = $data['mobile'] = $data['desktop'] = false;
	
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
		$agent = $_SERVER["HTTP_USER_AGENT"];
		if(preg_match("/(ipad|tablet)/i", $agent)) {
			return false;  
		} elseif(preg_match("/(android|webos|avantgo|iphone|ipod|blackberry|iemobile|bolt|boost|cricket|docomo|fone|hiptop|mini|opera mini|kitkat|mobi|palm|phone|pie|up\.browser|up\.link|webos|wos)/i", $agent)) {
			return true; 
		}
		return false;
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
function text_parse($text) {
	//$link_pattern = "/(http|https)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
	//$text = preg_replace($link_pattern, "<a href='\\0' rel='nofollow noopener noreferrer' target='_blank'>\\0</a>", $text);
	$url_pattern = '@(http(s)?)?(://)?(([a-zA-Z])([-\w]+\.)+([^\s\.]+[^\s]*)+[^,.\s])@';
	$text = preg_replace($url_pattern, '<a href="http$2://$4" rel="nofollow noopener noreferrer" target="_blank" title="$0">$0</a>', $text);
	return $text;
}



function moneyFormat($value,$currency) {
	if (in_array($currency, ['ARS','BRL','CAD','EUR','ILS','RUB','VND'])) {
		$value = number_format($value, 2, '.', ',');
	} else {
		$value = number_format($value, 2, ',', '.');
	}
	if($currency=='EUR'){
		return '€'.$value;
	} elseif($currency=='BRL') {
		return 'R$'.$value;
	} elseif($currency=='CNY') {
		return '¥'.$value;
	} elseif($currency=='HKD') {
		return 'HK$'.$value;
	} elseif($currency=='INR') {
		return '₹'.$value;
	} elseif($currency=='ILS') {
		return '₪'.$value;
	} elseif($currency=='JPY') {
		return '¥'.$value;
	} elseif($currency=='KRW') {
		return '₩'.$value;
	} elseif($currency=='MYR') {
		return 'RM'.$value;
	} elseif($currency=='MAD') {
		return $value.'.د.م.';
	} elseif($currency=='PHP') {
		return '₱'.$value;
	} elseif($currency=='RUB') {
		return $value.'p.';
	} elseif($currency=='SAR') {
		return $value.'﷼';
	} elseif($currency=='ZAR') {
		return 'R'.$value;
	} elseif($currency=='TWD') {
		return '元'.$value;
	} elseif($currency=='THB') {
		return $value.'฿';
	} elseif($currency=='TRY') {
		return $value.'₺';
	} elseif($currency=='GBP') {
		return '£'.$value;
	} elseif($currency=='VND') {
		return $value.'₫';
	} else {
		return '$'.$value;
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


function geoip($ip,$optional='city') {
	if($ip == null){
		$ip = (isset($_SERVER["HTTP_CF_CONNECTING_IP"]))? $_SERVER["HTTP_CF_CONNECTING_IP"] : $_SERVER["REMOTE_ADDR"];
	}
	include_once("Extras/geoip2.php");
	//dd($optional);
	return geoip2($ip,$optional);
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

function languages($lang='all') {
	include_once(__DIR__ ."/Extras/languages.php");
	if($lang == 'all'){
		return $languages;
	} else {
		return $languages[$lang];
	}
}


function currencies($isoCode='all') {
	include(__DIR__ ."/Extras/currencies.php");
	if($isoCode == 'all'){
			return array_keys($currencies);
	}
	return $currencies[$isoCode];
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



//should this be in another file? and return continent, language and timezone_range (for emails and console commands)??
function COUNTRY_CONTINENTS($countryCode) {
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
	
  //GetAvatar
  function avatar($user) {
   if(!empty($user) OR $user != null) {
    if(!is_string($user)) {
      if(!empty($user->avatar) OR $user->avatar != NULL) {
	//if avatar is facebook or google
	if (strpos($user->avatar, 'http') === 0) {
        	return $user->avatar;
	}
        return env('SHOWAVATAR_PATH').$user->avatar;
      } else {
        $avatar = $user->email;
      }
    } else { $avatar = $user; }
      $gravatar = md5(strtolower(trim($avatar)));
      $fallback = env('SHOWAVATAR_PATH').'avatar.png';
      return "https://s.gravatar.com/avatar/$gravatar?d=".$fallback;
    } elseif(isset($user->sex)){
			if($user->sex == 'm'){
				return env('SHOWAVATAR_PATH').'avatar-m.png';
			} elseif($user->sex == 'f'){
				return env('SHOWAVATAR_PATH').'avatar-f.png';
			}
		} else {
			return env('SHOWAVATAR_PATH').'avatar.png';
		}
   }
	
	//CRYPTO
	function encrypt($string,$key) {
		$iv = substr(hash('sha256', env('CRYPTO_STRING')), 0, 16);
		$encrypted = openssl_encrypt($string, "AES-256-CBC", $key, 0, $iv);
		$encrypted = strtr( $encrypted, "+/", "-_");
	  return $encrypted;
	}
	function decrypt($string,$key) {
		$string = strtr( $string, "-_", "+/");
		$iv = substr(hash('sha256', env('CRYPTO_STRING')), 0, 16);
		$decrypted = openssl_decrypt($string, "AES-256-CBC", $key, 0, $iv);
	  return $decrypted;
	}
	
	//FILE SIZES CALCULATOR TO BYTES
	function sizetobytes($size) {
    $unit = strtolower($size);
    $unit = preg_replace('/[^a-z]/', '', $unit);
    $value = intval(preg_replace('/[^0-9]/', '', $size));
    $units = array('b'=>0, 'kb'=>1, 'mb'=>2, 'gb'=>3, 'tb'=>4);
		$exponent = isset($units[$unit]) ? $units[$unit] : 0;
    return ($value * pow(1024, $exponent));            
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
	
  //Slug helper
  public function slug($data)
  {
    $replace = [
         '&lt;' => '', '&gt;' => '', '&#039;' => '', '&amp;' => '', '&quot;' => '', 'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä'=> 'Ae', '&Auml;' => 'A', 'Å' => 'A', 'Ā' => 'A', 'Ą' => 'A', 'Ă' => 'A', 'Æ' => 'Ae', 'Ç' => 'C', 'Ć' => 'C', 'Č' => 'C', 'Ĉ' => 'C', 'Ċ' => 'C', 'Ď' => 'D', 'Đ' => 'D', 'Ð' => 'D', 'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ē' => 'E', 'Ę' => 'E', 'Ě' => 'E', 'Ĕ' => 'E', 'Ė' => 'E', 'Ĝ' => 'G', 'Ğ' => 'G', 'Ġ' => 'G', 'Ģ' => 'G', 'Ĥ' => 'H', 'Ħ' => 'H', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 'Ī' => 'I', 'Ĩ' => 'I', 'Ĭ' => 'I', 'Į' => 'I', 'İ' => 'I', 'Ĳ' => 'IJ', 'Ĵ' => 'J', 'Ķ' => 'K', 'Ł' => 'K', 'Ľ' => 'K', 'Ĺ' => 'K', 'Ļ' => 'K', 'Ŀ' => 'K', 'Ñ' => 'N', 'Ń' => 'N', 'Ň' => 'N', 'Ņ' => 'N', 'Ŋ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'Oe', '&Ouml;' => 'Oe', 'Ø' => 'O', 'Ō' => 'O', 'Ő' => 'O', 'Ŏ' => 'O', 'Œ' => 'OE', 'Ŕ' => 'R', 'Ř' => 'R', 'Ŗ' => 'R', 'Ś' => 'S', 'Š' => 'S', 'Ş' => 'S', 'Ŝ' => 'S', 'Ș' => 'S', 'Ť' => 'T', 'Ţ' => 'T', 'Ŧ' => 'T', 'Ț' => 'T', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'Ue', 'Ū' => 'U', '&Uuml;' => 'Ue', 'Ů' => 'U', 'Ű' => 'U', 'Ŭ' => 'U', 'Ũ' => 'U', 'Ų' => 'U', 'Ŵ' => 'W', 'Ý' => 'Y', 'Ŷ' => 'Y', 'Ÿ' => 'Y', 'Ź' => 'Z', 'Ž' => 'Z', 'Ż' => 'Z', 'Þ' => 'T', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'ae', '&auml;' => 'ae', 'å' => 'a', 'ā' => 'a', 'ą' => 'a', 'ă' => 'a', 'æ' => 'ae', 'ç' => 'c', 'ć' => 'c', 'č' => 'c', 'ĉ' => 'c', 'ċ' => 'c', 'ď' => 'd', 'đ' => 'd', 'ð' => 'd', 'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ē' => 'e', 'ę' => 'e', 'ě' => 'e', 'ĕ' => 'e', 'ė' => 'e', 'ƒ' => 'f', 'ĝ' => 'g', 'ğ' => 'g', 'ġ' => 'g', 'ģ' => 'g', 'ĥ' => 'h', 'ħ' => 'h', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ī' => 'i', 'ĩ' => 'i', 'ĭ' => 'i', 'į' => 'i', 'ı' => 'i', 'ĳ' => 'ij', 'ĵ' => 'j', 'ķ' => 'k', 'ĸ' => 'k', 'ł' => 'l', 'ľ' => 'l', 'ĺ' => 'l', 'ļ' => 'l', 'ŀ' => 'l', 'ñ' => 'n', 'ń' => 'n', 'ň' => 'n', 'ņ' => 'n', 'ŉ' => 'n', 'ŋ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'oe', '&ouml;' => 'oe', 'ø' => 'o', 'ō' => 'o', 'ő' => 'o', 'ŏ' => 'o', 'œ' => 'oe', 'ŕ' => 'r', 'ř' => 'r', 'ŗ' => 'r', 'š' => 's', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'ue', 'ū' => 'u', '&uuml;' => 'ue', 'ů' => 'u', 'ű' => 'u', 'ŭ' => 'u', 'ũ' => 'u', 'ų' => 'u', 'ŵ' => 'w', 'ý' => 'y', 'ÿ' => 'y', 'ŷ' => 'y', 'ž' => 'z', 'ż' => 'z', 'ź' => 'z', 'þ' => 't', 'ß' => 'ss', 'ſ' => 'ss', 'ый' => 'iy', 'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'YO', 'Ж' => 'ZH', 'З' => 'Z', 'И' => 'I', 'Й' => 'Y', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O', 'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C', 'Ч' => 'CH', 'Ш' => 'SH', 'Щ' => 'SCH', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'YU', 'Я' => 'YA', 'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh', 'з' => 'z', 'и' => 'i', 'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c', 'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sch', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu', 'я' => 'ya', '.' => '', '"' => '', "'" => ''
     ];
     
     $data = strtr($data, $replace);
     $data = preg_replace('~[^\\pL\d.]+~u', '-', $data);
     $data = trim($data, '-');
     $data = preg_replace('~[^-\w.]+~', '', $data);
     return strtolower($data);
  }
  //returns new filename
  function slug_file($filename,$random) {
    $data = explode('.', $filename);
    $result = $this->slug($data[0]).$this->slug_random($random).'.'.$data[1];
    return strtolower($result);
  }
  //returns filename with a nmae you specify
  function slug_filename($filename,$name,$random) {
    $data = explode('.', $filename);
    $result = $this->slug($name).$this->slug_random($random).'.'.$data[1];
    return strtolower($result);
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
  function random($characters = 1,$numbers = false) {
		$chars = ($numbers)? '0123456789' : '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
		$count = strlen($chars);
		$bytes = random_bytes($characters);
		$random = '';
		foreach (str_split($bytes) as $byte) {
				$random .= $chars[ord($byte) % $count];
		}
		return $random;
	}


//CHECK if url has http
function telto($phone) {
	return str_replace(['+', '(', ')', '-', ' '], '', $phone);
}

//CHECK if url has http
function link($url) {
	if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
			$url = "http://" . $url;
	}
	return $url;
}

//CHECK if domain or email domain exist.
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

//CHECK if domain or email domain exist.
function domain_check($value) {
	$domain = (strpos($value, '@') !== false)? substr(strrchr($value, "@"), 1) : $value;
	if($domain) {
	//$handle = dns_get_record($url);
    	$check = checkdnsrr($domain, "MX");
	return (!empty($check))? true : false;
	}
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
		background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='%23dc3545' viewBox='-2 -2 7 7'%3e%3cpath stroke='%23dc3545' d='M0 0l3 3m0-3L0 3'/%3e%3ccircle r='.5'/%3e%3ccircle cx='3' r='.5'/%3e%3ccircle cy='3' r='.5'/%3e%3ccircle cx='3' cy='3' r='.5'/%3e%3c/svg%3E");
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

	
}
