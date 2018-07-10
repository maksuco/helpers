<?php

namespace Maksuco\Helpers;

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
	

//GET GEO CITY AND COUNTRY
function location($ip) {
  $query = unserialize(file_get_contents('http://ip-api.com/php/'.$ip));
	//$type = (ip2long($ip)); ip
	//$type = (strlen($ip) == 2); country code
	if($query AND $query['status'] == 'success') {
    //continent
	$COUNTRY_CONTINENTS = ["AF"=>"AS","AX"=>"EU","AL"=>"EU","DZ"=>"AF","AS"=>"OC","AD"=>"EU","AO"=>"AF","AI"=>"NA","AQ"=>"AN","AG"=>"NA","AR"=>"SA","AM"=>"AS","AW"=>"NA","AU"=>"OC","AT"=>"EU","AZ"=>"AS","BS"=>"NA","BH"=>"AS","BD"=>"AS","BB"=>"NA","BY"=>"EU","BE"=>"EU","BZ"=>"NA","BJ"=>"AF","BM"=>"NA","BT"=>"AS","BO"=>"SA","BA"=>"EU","BW"=>"AF","BV"=>"AN","BR"=>"SA","IO"=>"AS","BN"=>"AS","BG"=>"EU","BF"=>"AF","BI"=>"AF","KH"=>"AS","CM"=>"AF","CA"=>"NA","CV"=>"AF","KY"=>"NA","CF"=>"AF","TD"=>"AF","CL"=>"SA","CN"=>"AS","CX"=>"AS","CC"=>"AS","CO"=>"SA","KM"=>"AF","CD"=>"AF","CG"=>"AF","CK"=>"OC","CR"=>"NA","CI"=>"AF","HR"=>"EU","CU"=>"NA","CY"=>"AS","CZ"=>"EU","DK"=>"EU","DJ"=>"AF","DM"=>"NA","DO"=>"NA","EC"=>"SA","EG"=>"AF","SV"=>"NA","GQ"=>"AF","ER"=>"AF","EE"=>"EU","ET"=>"AF","FO"=>"EU","FK"=>"SA","FJ"=>"OC","FI"=>"EU","FR"=>"EU","GF"=>"SA","PF"=>"OC","TF"=>"AN","GA"=>"AF","GM"=>"AF","GE"=>"AS","DE"=>"EU","GH"=>"AF","GI"=>"EU","GR"=>"EU","GL"=>"NA","GD"=>"NA","GP"=>"NA","GU"=>"OC","GT"=>"NA","GG"=>"EU","GN"=>"AF","GW"=>"AF","GY"=>"SA","HT"=>"NA","HM"=>"AN","VA"=>"EU","HN"=>"NA","HK"=>"AS","HU"=>"EU","IS"=>"EU","IN"=>"AS","ID"=>"AS","IR"=>"AS","IQ"=>"AS","IE"=>"EU","IM"=>"EU","IL"=>"AS","IT"=>"EU","JM"=>"NA","JP"=>"AS","JE"=>"EU","JO"=>"AS","KZ"=>"AS","KE"=>"AF","KI"=>"OC","KP"=>"AS","KR"=>"AS","KW"=>"AS","KG"=>"AS","LA"=>"AS","LV"=>"EU","LB"=>"AS","LS"=>"AF","LR"=>"AF","LY"=>"AF","LI"=>"EU","LT"=>"EU","LU"=>"EU","MO"=>"AS","MK"=>"EU","MG"=>"AF","MW"=>"AF","MY"=>"AS","MV"=>"AS","ML"=>"AF","MT"=>"EU","MH"=>"OC","MQ"=>"NA","MR"=>"AF","MU"=>"AF","YT"=>"AF","MX"=>"NA","FM"=>"OC","MD"=>"EU","MC"=>"EU","MN"=>"AS","ME"=>"EU","MS"=>"NA","MA"=>"AF","MZ"=>"AF","MM"=>"AS","NA"=>"AF","NR"=>"OC","NP"=>"AS","AN"=>"NA","NL"=>"EU","NC"=>"OC","NZ"=>"OC","NI"=>"NA","NE"=>"AF","NG"=>"AF","NU"=>"OC","NF"=>"OC","MP"=>"OC","NO"=>"EU","OM"=>"AS","PK"=>"AS","PW"=>"OC","PS"=>"AS","PA"=>"NA","PG"=>"OC","PY"=>"SA","PE"=>"SA","PH"=>"AS","PN"=>"OC","PL"=>"EU","PT"=>"EU","PR"=>"NA","QA"=>"AS","RE"=>"AF","RO"=>"EU","RU"=>"EU","RW"=>"AF","SH"=>"AF","KN"=>"NA","LC"=>"NA","PM"=>"NA","VC"=>"NA","WS"=>"OC","SM"=>"EU","ST"=>"AF","SA"=>"AS","SN"=>"AF","RS"=>"EU","SC"=>"AF","SL"=>"AF","SG"=>"AS","SK"=>"EU","SI"=>"EU","SB"=>"OC","SO"=>"AF","ZA"=>"AF","GS"=>"AN","ES"=>"EU","LK"=>"AS","SD"=>"AF","SR"=>"SA","SJ"=>"EU","SZ"=>"AF","SE"=>"EU","CH"=>"EU","SY"=>"AS","TW"=>"AS","TJ"=>"AS","TZ"=>"AF","TH"=>"AS","TL"=>"AS","TG"=>"AF","TK"=>"OC","TO"=>"OC","TT"=>"NA","TN"=>"AF","TR"=>"AS","TM"=>"AS","TC"=>"NA","TV"=>"OC","UG"=>"AF","UA"=>"EU","AE"=>"AS","GB"=>"EU","UM"=>"OC","US"=>"NA","UY"=>"SA","UZ"=>"AS","VU"=>"OC","VE"=>"SA","VN"=>"AS","VG"=>"NA","VI"=>"NA","WF"=>"OC","EH"=>"AF","YE"=>"AS","ZM"=>"AF","ZW"=>"AF"];
    //lang
    if(in_array($query['countryCode'], ["AR","BO","CL","CO","CR","CU","CW","DO","EC","ES","HN","GQ","GT","MX","NI","PR","PA","UY","SV","VE"])) {
      $lang = "es";
    } elseif(in_array($query['countryCode'], ["AG","AU","BS","BB","BZ","CA","DO","EN","IE","JM","GD","GY","LC","NZ","TT","UK","US","VC"])) {
      $lang = "en";
    } elseif(in_array($query['countryCode'], ["PT","BR","MZ","AO"])) {
      $lang = "pt";
    } elseif(in_array($query['countryCode'], ["FR","SN"])) {
      $lang = "fr";
    } else {
      $lang = "en";
    }
    $data = ['city' => $query['city'], 'country' => $query['countryCode'], 'timezone' => $query['timezone'], 'continent' => $COUNTRY_CONTINENTS[$query['countryCode']], 'lang' => $lang, 'isp' => $query['isp']];
    return $data;
  } else {
    return false;
  }
}
	
  //GetAvatar
  function avatar($user) {
   if(!empty($user) OR $user != null) {
    if(!is_string($user)) {
      if(!empty($user->avatar) OR $user->avatar != NULL) {
        return env('SHOWAVATAR_PATH').$user->avatar;
      } else {
        $avatar = $user->email;
      }
    } else { $avatar = $user; }
      $gravatar = md5(strtolower(trim($avatar)));
      $fallback = env('SHOWAVATAR_PATH').'avatar.png';
      return "https://s.gravatar.com/avatar/$gravatar?d=".$fallback;
    } else { return env('SHOWAVATAR_PATH').'avatar.png'; }
   }
	
	//CRYPTO
	function encrypt($string,$key) {
		$iv = substr(hash('sha256', env('CRYPTO_STRING')), 0, 16);
		$encrypted = openssl_encrypt($string, "AES-256-CBC", $key, 0, $iv);
	    return $encrypted;
	}
	function decrypt($string,$key) {
		$iv = substr(hash('sha256', env('CRYPTO_STRING')), 0, 16);
		$decrypted = openssl_decrypt($string, "AES-256-CBC", $key, 0, $iv);
	    return $decrypted;
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
        return '-'.str_random($characters);
      } else {
        return '';
      }
    }
    return '-'.$characters;
  }

//CHECK if url has http
function link($url) {
    if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
        $url = "http://" . $url;
    }
    return $url;
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
