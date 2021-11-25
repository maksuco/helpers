<?php

  use GeoIp2\Database\Reader;

  function geoip2($ip,$optional,$key,$base_path=false) {
    $geo = new stdClass();
    $geo->ip = $ip;
    $geo->country = new stdClass();
    $geo->location = new stdClass();
    //DATA
    $espanol = ["ES", "AR", "BO", "CL", "CO", "CR", "CU", "CW", "DO", "EC", "HN", "MX", "NI", "PA", "PE", "PR", "PY", "VE", "UY", "GT", "SV"];
    $phone_codes = [
      "AI"=>"+1 264", "AR"=>"+54", "AW"=>"+297", "BS"=>"+1", "BB"=>"+1", "BZ"=>"+501", "BM"=>"+1", "BO"=>"+591", "BR"=>"+55", "VG"=>"+1 284", "CA"=>"+1", "KY"=>"+1-345", "CL"=>"+56", "CO"=>"+57", "CR"=>"+506", "CU"=>"+53", "CW"=>"+599", "DM"=>"+1", "DO"=>"+1", "EC"=>"+593", "SV"=>"+503", "FK"=>"+500", "GL"=>"+299", "GP"=>"+590", "GT"=>"+502", "GY"=>"+592", "HT"=>"+509", "HN"=>"+504", "JM"=>"+1", "MX"=>"+52", "MS"=>"+1 664", "NI"=>"+505", "PA"=>"+507", "PY"=>"+595", "PE"=>"+51", "PR"=>"+1", "BL"=>"+590", "KN"=>"+1", "LC"=>"+1", "MF"=>"+1 599", "PM"=>"+508", "VC"=>"+1", "SR"=>"+597", "TT"=>"+1", "US"=>"+1", "UY"=>"+598", "VE"=>"+58", //America
      "DZ"=>"+213", "AO"=>"+244", "BJ"=>"+229", "BW"=>"+267", "BF"=>"+226", "BI"=>"+257", "CM"=>"+237", "CV"=>"+238", "CF"=>"+236", "KM"=>"+269", "CD"=>"+243", "DJ"=>"+253", "EG"=>"+20", "GQ"=>"+240", "ER"=>"+291", "ET"=>"+251", "GA"=>"+241", "GM"=>"+220", "GH"=>"+233", "GN"=>"+224", "GW"=>"+245", "CI"=>"+225", "KE"=>"+254", "LS"=>"+266", "LR"=>"+231", "LY"=>"+218", "MG"=>"+261", "MW"=>"+265", "ML"=>"+223", "MR"=>"+222", "MU"=>"+230", "MA"=>"+212", "MZ"=>"+258", "NA"=>"+264", "NE"=>"+227", "NG"=>"+234", "CG"=>"+242", "RE"=>"+262", "RW"=>"+250", "SH"=>"+290", "ST"=>"+239", "SN"=>"+221", "SC"=>"+248", "SL"=>"+232", "SO"=>"+252", "ZA"=>"+27", "SS"=>"+211", "SD"=>"+249", "SZ"=>"+268", "TZ"=>"+255", "TG"=>"+228", "TN"=>"+216", "UG"=>"+256", "EH"=>"+212", "ZM"=>"+260", "ZW"=>"+263", //Africa
      "AF"=>"+93", "AM"=>"+374", "AZ"=>"+994", "BH"=>"+973", "BD"=>"+880", "BT"=>"+975", "BN"=>"+673", "KH"=>"+855", "CN"=>"+86", "GE"=>"+995", "HK"=>"+852", "IN"=>"+91", "ID"=>"+62", "IR"=>"+98", "IQ"=>"+964", "IL"=>"+972", "JP"=>"+81", "JO"=>"+962", "KZ"=>"+7", "KW"=>"+965", "KG"=>"+996", "LA"=>"+856", "LB"=>"+961", "MO"=>"+853", "MY"=>"+60", "MV"=>"+960", "MN"=>"+976", "MM"=>"+95", "NP"=>"+977", "KP"=>"+850", "OM"=>"+968", "PK"=>"+92", "PH"=>"+63", "QA"=>"+974", "SA"=>"+966", "SG"=>"+65", "KR"=>"+82", "LK"=>"+94", "SY"=>"+963", "TW"=>"+886", "TJ"=>"+992", "TH"=>"+66", "TR"=>"+90", "TM"=>"+993", "AE"=>"+971", "UZ"=>"+998", "VN"=>"+84", "YE"=>"+967", //Asia
      "AL"=>"+355", "AD"=>"+376", "AT"=>"+43", "BY"=>"+375", "BE"=>"+32", "BA"=>"+387", "BG"=>"+359", "HR"=>"+385", "CY"=>"+357", "CZ"=>"+420", "DK"=>"+45", "EE"=>"+372", "FO"=>"+298", "FI"=>"+358", "FR"=>"+33", "DE"=>"+49", "GI"=>"+350", "GR"=>"+30", "HU"=>"+36", "IS"=>"+354", "IE"=>"+353", "IM"=>"+44", "IT"=>"+39", "XK"=>"+381", "LV"=>"+371", "LI"=>"+423", "LT"=>"+370", "LU"=>"+352", "MK"=>"+389", "MT"=>"+356", "MD"=>"+373", "MC"=>"+377", "ME"=>"+382", "NL"=>"+31", "NO"=>"+47", "PL"=>"+48", "PT"=>"+351", "RO"=>"+40", "RU"=>"+7", "SM"=>"+378", "RS"=>"+381", "SK"=>"+421", "SI"=>"+386", "ES"=>"+34", "SE"=>"+46", "CH"=>"+41", "UA"=>"+380", "GB"=>"+44", "VA"=>"+39", //Europe
      "AS"=>"+1 684", "AU"=>"+61", "CK"=>"+682", "TL"=>"+670", "FJ"=>"+679", "PF"=>"+689", "GU"=>"+1 671", "KI"=>"+686", "MH"=>"+692", "FM"=>"+691", "NR"=>"+674", "NC"=>"+687", "NZ"=>"+64", "NU"=>"+683", "NF"=>"+672", "MP"=>"+1 670", "PW"=>"+680", "PG"=>"+675", "PN"=>"+870", "WS"=>"+685", "SB"=>"+677", "TK"=>"+690", "TV"=>"+688", "VU"=>"+678" //Oceania
    ];

    //check if private or local ip
    // | FILTER_FLAG_NO_PRIV_RANGE |  FILTER_FLAG_NO_RES_RANGE
    //!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) OR 
    if(in_array($ip, ['localhost','127.0.0.1'])) {
      return geoip2NotFound($geo);
    }
    if($optional=='ip-api') {
      $geo_data = json_decode(file_get_contents("http://ip-api.com/json/".$ip."?fields=11587583"));
      //DATA
      $continent = $geo->continent_code = $geo_data->continentCode;
      $geo->continent_name = $geo_data->continent;
      
      $country = $geo->country_code = $geo->country->isoCode = $geo_data->countryCode;
      $geo->country_name = $geo->country->name = $geo_data->country;
      
      $geo->city_name = $geo->location->city_name = $geo_data->city;
      $geo->city_geonameid = null;
      $geo->state_name = $geo->location->state_name = $geo_data->regionName;
      $geo->state_code = $geo->location->state_isoCode = $geo_data->region;

      $geo->timezone = $geo_data->timezone;
      $lang = (in_array($country, $espanol))? 'es' : null;
      $geo->lang = (!empty($lang))? $lang : 'en';
      $geo->prefix = $phone_codes[$geo->country_code];
      $geo->currency = $geo_data->currency;


    } elseif($optional=='ipstack') {
      $key = $key ?? env('IPSTACK_KEY');
      $geo_data = json_decode(file_get_contents("https://api.ipstack.com/".$ip."?access_key=".$key));
      //DATA
      $continent = $geo->continent_code = $geo_data->continent_code;
      $geo->continent_name = $geo_data->continent_name;
      
      $country = $geo->country_code = $geo->country->isoCode = $geo_data->country_code;
      $geo->country_name = $geo->country->name = $geo_data->country_name;
      
      $geo->city_name = $geo->location->city_name = $geo_data->city;
      $geo->city_geonameid = $geo_data->location->geoname_id;
      $geo->state_name = $geo->location->state_name = $geo_data->region_name;
      $geo->state_code = $geo->location->state_isoCode = $geo_data->region_code;

      $geo->timezone = $geo_data->time_zone->id;
      $lang = (in_array($country, $espanol))? 'es' : $geo_data->location->languages->code;
      $geo->lang = (!empty($lang))? $lang : 'en';
      $geo->prefix = $phone_codes[$geo->country_code];
      $geo->currency = $geo_data->currency->code;


    } else {
      //MAXMIND
      try {
        if($base_path){
          $reader = new Reader(base_path().'/vendor/maksuco/helpers-geo/src/GeoLite2-City.mmdb');
        } else {
          $reader = new Reader('vendor/maksuco/helpers-geo/src/GeoLite2-City.mmdb');
        }
        //$geo_data = new Reader(__DIR__.'/GeoLite2-City.mmdb');
        $geo_data = $reader->city($ip);
      } catch (AddressNotFoundException $e) {
        return geoip2NotFound($geo); //null;
      } catch (Exception $e) {
        return geoip2NotFound($geo); //null;
      }

      $continent = $geo->continent_code = $geo_data->continent->code;
      $geo->continent_name = $geo_data->continent->name;
      $geo->continent_names = $geo_data->continent->names;
      
      $country = $geo->country_code = $geo->country->isoCode = $geo_data->country->isoCode;
      $geo->country_name = $geo->country->name = $geo_data->country->name;
      $geo->country_names = $geo_data->country->names;
      
      $geo->city_name = $geo->location->city_name = $geo_data->city->name;
      $geo->city_names = $geo_data->city->names;
      $geo->city_geonameid = $geo_data->city->geonameId;
      $geo->state_name = $geo->location->state_name = $geo_data->mostSpecificSubdivision->name;
      $geo->state_code = $geo->location->state_isoCode = $geo_data->mostSpecificSubdivision->isoCode;

      $geo->timezone = $geo_data->location->timeZone;
      $lang = (in_array($country, $espanol))? 'es' : $geo_data->locales[0];
      $geo->lang = (!empty($lang))? $lang : 'en';
      $geo->prefix = $phone_codes[$geo->country_code];

      if($optional!='city'){
        $isp = new Reader('vendor/maksuco/helpers-geo/src/GeoLite2-ASN.mmdb');
        //$isp = new Reader(__DIR__.'/GeoLite2-ASN.mmdb');
        $isp = $isp->asn($ip);
        $geo->isp = $isp->autonomousSystemOrganization;
      }

    }


    //timezone_range check
    if(in_array($continent, ["SA", "NA"])) {
      $geo->timezone_range = "america";
    } elseif($continent == "EU") {
      $geo->timezone_range = "europe";
    } elseif($continent == "AS") {
      $geo->timezone_range = "asia";
    } elseif($continent == "AF") {
      $geo->timezone_range = "europe";
    } elseif(in_array($continent, ["AU","OC"])) {
      $geo->timezone_range = "oceania";
    } else {
      $geo->timezone_range = "america";
    }

    return $geo;
  }

  function geoip2NotFound($geo) {
    $geo->country_code = $geo->country->isoCode = 'US';
    $geo->country_name = "United States";
    $geo->city_name = null;
    $geo->state_name = null;
    $geo->state_code = null;
    $geo->timezone_range = "america";
    $geo->timezone = $geo->location->timeZone = "America/New_York";
    $geo->timezone_range = "america";
    $geo->lang = 'en';
    $geo->isp = 'Server';
    $geo->prefix = '+1';
    return $geo;
  }