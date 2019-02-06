<?php

  use GeoIp2\Database\Reader;

  function geoip2($ip) {
    $geo = new Reader(__DIR__.'/GeoLite2-City.mmdb');
    $geo = $geo->city($ip);
    $countryCode = $geo->country->isoCode;
    $geo->lang = $geo->locales[0];

    //timezone_range check
    if(in_array($countryCode, ["AR", "BO", "CA", "CL", "CO", "CR", "CU", "CW", "DO", "EC", "HN", "MX", "NI", "PA", "PE", "PR", "PY", "VE", "UY", "GT", "SV", "US"])) {
      $geo->timezone_range = "america";
    } elseif(in_array($countryCode, ["AG","AU","BS","BB","BZ","CA","DO","EN","IE","JM","GD","GY","LC","NZ","TT","UK","US","VC"])) {
      $geo->timezone_range = "europe";
    } elseif(in_array($countryCode, ["CN","","JP","RU"])) {
      $geo->timezone_range = "asia";
    } elseif(in_array($countryCode, ["FR","SN"])) {
      $geo->timezone_range = "aceania";
    } else {
      $geo->timezone_range = "america";
    }

    return $geo;
  }