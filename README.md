# Helpers

This package has a few php helpers, for everyday tasks


## Installation

This packages requires Spatie/Analytics for the charts
You can install the package via composer:
``` bash
$ composer require maksuco/Helpers
OR
$ composer require maksuco/Helpers:dev-master
```
This Package works with auto discovery in Laravel +5.5, but is compatible with older versions

## Usage
```php
<?php
//In laravel
\Helpers::mobile();
//In php
$helpers = new \Maksuco\Helpers\Helpers();
$helpers->mobile();
//use Illuminate\Support\Facades\Helpers;

```

# Device check: Mobile, Tables, Desktop

Response with the correct device, example: (300,'table',200), the response is 300 when is mobile OR 200 if it's desktop. ('mobile','table','desktop')

```php
  \Helpers::agent($mobile,$table,$desktop);
```

# Check if device is Mobile

```php
  \Helpers::mobile();
  //Returns true or false
```

# Check browser locale
Returns the browser locale, for example 'en', you send the available languages of  your site, the first one is the base
```php
  \Helpers::browserLocale(['en','es']);
```

# Check if device is Mobile, Operating System and Browser

```php
  \Helpers::user_agent();
  //Returns Array ( [desktop] => 1 [mobile] => [tablet] =>  [device] => desktop [browser] => Chrome [os] => Macintosh [result] => Macintosh Chrome )
  //Returns ['lang'], and ['estimate']=true if is not exact data
```

# Check if visitor is a bot

```php
  \Helpers::botDetected();
  //Returns true or false
```

# Avatar

This function helps you show the user avatar or the gravatar, just send the user array or email.
It returns the image path or base64

```php

  $img = \Helpers::avatar($user);
  OR
  {{\Helpers::avatar($user->email)}}

```

# First Name

Helps you show the user first name, from a full name, max length of the returned name is 11

```php

  {{\Helpers::firstname($fullname)}}
  //Gina Gutierrez returns Gina
  //Gi Gutierrez returns Gi Gutierrez

```

# Name Initials

```php

  {{\Helpers::initials($fullname)}}
  //SEND Sofia Loren
  //GET SL

```


# CONVERT LETTERS TO NUMBERS

```php

  $string = Helpers::lettersToNumbers($string,$phone=false);

```

# Active Navigation Page

Send the current page name, example 'about' or 'contactenos', it checks if theres a variable named $active (send from the controller) then checks if the route has a name and then checks the first segment of the page, example: about/history

```php

  {{\Helpers::nav_active($page)}}
  //SEND: nav_active('about')
  //RETURNS: 'active'

```

# Text parser

 Convert plain text to include real html links (blank is optional, default is true)

```php

  {{\Helpers::text_parse($text,$blank)}}
  //SEND: Welcome to http:://apple.com
  //RETURNS: Welcome to <a href="http:://apple.com">http:://apple.com</a>

```

# Find text between 2 strings or replace
Returns an array with all results

```php

  {{\Helpers::getTextBetween($text,$start,$end)}}
  If you want to replace the text between two strings use
  {{\Helpers::replaceTextBetween($text,$start,$end,$replace)}}

```

# Get all countries

 A list of countries to show in a select

```php

  {{\Helpers::countries('en')}}
  //RETURNS: Array
  {{\Helpers::country('US')}}
  //RETURNS: "id": 241,"code": "US","name_en": "United States","name_es": "Estados Unidos","status": null,"tel": 1,"lang": "en","currency": "USD","currency_symbol": "$","timezone_group": null

```

# Get all cities by country

 A list of cities in country

```php

  {{\Helpers::cities('US')}}
  //RETURNS:"name": "Salta","region": "A","country": "AR","latitude": "-24.78835","longitude": "-65.41266","slug": "salta"
```

# Check continent

 Returns the continent by name, simplify returns Europe if eu or america if anything else

```php

  {{\Helpers::continent('US')}}
  //RETURNS: 'america'
  {{\Helpers::continent('FR')}}
  //RETURNS: 'europe'

```

# Get all timezones

 A list of timezones to show in a select

```php
  {{\Helpers::timezones()}}
  //RETURNS: Array
```

# Get all languages or lang code name

```php

  {{\Helpers::languages()}}
  //RETURNS: Array
  {{\Helpers::languages('en')}}
  //RETURNS: 'english'

```

# Get all currencies or currency details for echo

 A list of countries to show in a select or currency details like symbol, decimals, name, etc..

```php

  {{\Helpers::currencies()}}
  //RETURNS: Array of isoCodes
  {{\Helpers::currencies('complete')}}
  //RETURNS: Array of all currencies with: name, isoCode, symbol and other data
  {{\Helpers::currencies('usd')}}
  //RETURNS: All data of the currency
  {{\Helpers::currency_format('10000.00','usd',false)}}
  //'10000.00','usd' RETURNS: $10,000 usd
  //'100.30','usd' RETURNS: $100.30 usd
  //'10000.30','eur' RETURNS: 10.000,30 €
  //'10000.00','cop',true RETURNS: Array ["result" => "$10.000""symbol" => "$""htmlEntity" => "&#x20B1;""amount" => "10.000""isoCode" => "COP""symbolFirst" => true"decimalSeparator" => ",""thousandsSeparator" => "."]

```

# Money Format

```php

  {{\Helpers::moneyFormat($value,$currency)}}
  //SEND: 1234.56,'EUR' RETURNS: €1,234.56
  //SEND: 1234.00,'USD' RETURNS: $1,234

```

# anyNumberFormat($value, $currency = null)

```php
  {{\Helpers::anyNumberFormat($value,$currency)}}
echo \Helpers::anyNumberFormat(1000) // 1.000
echo \Helpers::anyNumberFormat("90%") // 90%
echo \Helpers::anyNumberFormat("90.9%") // 90%
echo \Helpers::anyNumberFormat('$1000.00') // 1.000
echo \Helpers::anyNumberFormat('$1000.50', "usd") // $1,000.50
echo \Helpers::anyNumberFormat("1000.50", "eur") // € 1.000,50

```

# Currency Money Exchange

```php

  {{\Helpers::currency_exchange($amount, $from, $to, $round)}}
  //SEND: 1,'EUR','USD' RETURNS: 1,99 (SAMPLE)
  //SEND: 1,'EUR','USD',true RETURNS: 2 (SAMPLE)

```

# Decimal Format

Useful for saving numbers on mysql decimal columns
```php

  {{\Helpers::decimalsFormat($number)}}
  //SEND: 1,234.56 RETURNS: 1234.56
  //SEND: 1,234 RETURNS: 1234.00
  {{\Helpers::decimalsFormat($number,false)}} //NO CENTS
  //SEND: 1,234.560 RETURNS: 1234560
  //SEND: 1,234 RETURNS: 1234

```

# Location GEOIP

Get the city, country, language and other data from the IP:
This product includes GeoLite2 data created by MaxMind, available from
<a href="https://www.maxmind.com">https://www.maxmind.com</a> also requires composer require maksuco/helpers-geo.
https://github.com/maxmind/GeoIP2-php
Even better you can use 'ip-api' or 'ipstack' (ipstack requires a third argument for the ipstack key or IPSTACK_KEY=xxx on .env file - laravel)

```php

  $location_data = \Helpers::geoip($ip); //\Helpers::geoip($ip,'option'); OR \Helpers::geoip($ip,'ipstack','my_ipstack_key');
  $location_data = \Helpers::geoipLaravel($ip); //\Helpers::geoip($ip,'option'); OR \Helpers::geoip($ip,'ipstack','my_ipstack_key');

```
if you need the function to provide the ip, just put null in the $ip.
if you also want the isp info, just include the second call.


## Date in IP TimeZone

```php

  \Helpers::timezone($ip,Carbon::now());

```

# Location distance between 2 points

The units is optional, default is "miles"

```php
  $distance = \Helpers::distance($lat1, $lon1, $lat2, $lon2, $unit = "K");
```


## Append to json (only works with first level for now)
Send new data to append to a json data or subcategory (subcategory and limit are optional).

You send the DB column as $json, the new object or array as $new.

```php

  \Helpers::appendtojson($json,$new,$subcategory,$limit)

```
LImit, sets a limit for the amounts of records


## Modify csv string action=add,remove,check
Send id's to add, remove or check if exist in csv string

```php

  \Helpers::csvstring($action,$data,$new)

```


## Modify array with action=add,remove,check
Send new data to add, remove, check if exist in array or invert
Works with Sequential and Associative arrays
Invert adds the new if doesn't exist, or removes it if exist and returns the action "added" or "removed"
```php

  \Helpers::array_process($action,$array,$new)

	//$array = ['michael','gina'];
  //array_process('add',$array,'bob') returns ['michael','gina','bob']

  //array_process('remove',$array,'michael') returns ['gina']

  //array_process('invert',$array,'michael') returns "removed" MALLLLLLl

  //Associative
	//$array = ['michael'=>'m'];
	//$new = ['michael'=>'something','donald'=>'duck','bob'=>'m'];
  //array_process('add',$array2,$new2) returns ['michael'=>'something','donald'=>'duck','bob'=>'m']

	//array_process('check',$array,'gina') returns TRUE

```


# Collection Relations Append

Include in a collection the columns from another table with just one extra query
$principal_relation_column = the principal reference INT, typically id (This is optional)
### Examples: ($user,$post,'user_id',['post_name'=>'name'])

```php
  \Helpers::collection_relation($principal_collection,$second_collection,$second_relation_column,['new_column'=>'second_column_name'],$principal_relation_column)
```



# Column: Array and Json check

Check if a value is in a column (Works with json, array and string explode) //only 1 level
RETURNS: true or false

```php
  {{(\Helpers::column_check($data,$value))? 'YES!':'NO!'}} //($user->favorites,124)
```

# Column Process (if is in column, it will delete it, if not it will add it)

```php
  \Helpers::column_process($data,$table,$column,$value) //($user,'users','favorites',124)
```



# Links

Check if a domain doesn't have the http and adds it, and other links, domains helpers

```php

  {{\Helpers::link($account->domain)}}
  //SEND: somedomain.com
  //RETURNS: http://somedomain.com
  //SEND: mailto:xxxx
  //RETURNS: mailto:xxxx

```

# Get Domain from email

```php

  $domain = \Helpers::domain_from_email($email);
  //returns the domain from an email if it's not a free service like gmail.com, else it returns false

```

# Get Domain from url

```php

  $domain = \Helpers::domain_from_url($url);
  //returns the domain.com from http://www.domain.com/something
  \Helpers::domain_from_url($url,true); //subdomain true
  //returns the account.domain.com from http://account.domain.com/something
```

# Get html sections from url
You need the dom extension https://stackoverflow.com/questions/14395239/class-domdocument-not-found

```php

  $domain = \Helpers::url_html($url);
  //returns the body content of url
	$domain = \Helpers::url_html($url,'div');
	//returns a string with first div content
	$domain = \Helpers::url_html($url,'#home',true);
	//returns the section with id="home" and true converts all img src and links href to full urls.
	//using id selects the entire section, using elements only selects the content.
```


# Transform number to telto number

```php

  {{\Helpers::telto($phone)}}
  //SEND: +1 (305) 890 8989
  //RETURNS: 13058908989

```


# GET video id of youtube or vimeo link, if is already is returns the same

```php

  {{\Helpers::getVideoID($provider,$string)}}
  //SEND: 'youtube','https://www.youtube.com/watch?v=12345'
  //RETURNS: 12345
  //SEND: 'youtube','12345'
  //RETURNS: 12345
  //SEND: null,'https://host.com/file.mp4'
  //RETURNS: https://host.com/file.mp4

```



# Email and Domain Check

```php

  if(\Helpers::email_check($email)) {}
  //returns if the email is valid: true or false
  //Also checks if the domain exist
  OR

  if(\Helpers::domain_check($email)) {}
  //returns the domain from the email and checks if it exist
  OR
  if(\Helpers::domain_check('maksuco.com')) {}
  //Checks if the domain exist

```



# Get Domain Name from url

```php

  \Helpers::domainName('https://apple-Study.edu.us')
  //returns Apple Study
  OR
  \Helpers::domainName('https://apple.us')
  //returns Apple
  OR
  \Helpers::domainName('https://www.maksuco.com')
  //returns Maksuco

```



# Get Primary Domain from url

```php

  \Helpers::domainPrimary('https://www.apple-Study.edu.us')
  //returns apple-Study.edu.us
  OR
  \Helpers::domainName('https://apple.us')
  //returns apple.us
  OR
  \Helpers::domainName('https://l.maksuco.com')
  //returns maksuco.com

```


## Get file type
```php
  \Helpers::getFileType('xxx.mov');
  //returns video
```


## File size to bytes calculator
Send '1 mb' and get the result in bytes, send measurements in: b, kb, mb, gb, tb

```php
  \Helpers::sizetobytes('1 mb');
  //returns xxxx bytes
```


## Generate random string
Send the length of the random

```php
  \Helpers::random(4);
  //returns 4 letters mix with numbers
  \Helpers::random(4,true);
  //if you want only numbers
  \Helpers::random(4,false);
  //if you want only letters
```



## Generate random name
Names for testing, send 'name', 'lastname' or 'fullname' or leave empty for fullname

```php
  \Helpers::random_name($type);
  //returns John
```

## Generate random quote
```php
  \Helpers::random_quote();
  //returns Something special
```

## Hide part of the string like an api_key
```php
  \Helpers::hide_string($string);
  //returns 3234****9099
  \Helpers::hide_string($string, $middle = 'xx');
  //returns 3234xx9099
  \Helpers::hide_string('455667867897', $middle = 'xxddd','start');
  //returns with 'start' 4556xxddd
  //returns with 'end' xxddd7897
```


## Greetings by time of day
Returns good afternoon, good morning etc.. (timezone is optional)

```php
  \Helpers::greetings_by_time($timezone);
  //Returns: "Good morning", "Good afternoon", "Good evening" or "Good night"
```


## Day name by day difference
Returns today, tomorrow, 10 days a go, etc...

```php
  \Helpers::date_day($days_difference,$lang);
  //lang is optional
```

## Filename Parsing

Get a filename name from a string or url, you can also parse it and get basename, extension and filename

```php

  $filename = \Helpers::filename('http://xxx.com/this_is_the_name.png?v=xxx');
  //RETURNS: this_is_the_name.png
  OR
  $filename = \Helpers::filename('http://yyyy.com/this_is_the_name.png',true);
  //RETURNS ARRAY: basename: this_is_the_name.png, extension: png, filename: this_is_the_name
  //USE: $filename->basename

```

# Slugs

Here's an example of how to implement the slug function to transform names to slugs:

```php

  $slug = \Helpers::slug('Hi how are you? Muy@#$%^&*good');
  //RETURNS: hi-how-are-you-muy-good
  OR
  $slug = \Helpers::slug($name);

```

Transform file names, the second argument specifies a random addon at the end, can be text or INT

```php

  $slug = \Helpers::slug_file('Hi how are you? Muy@#$%^&*good.jpg',0);
  //hi-how-are-you-muy-good.jpg
  OR
  $slug = \Helpers::slug_file($file->getClientOriginalName(),5);
  //hi-how-are-you-muy-good-hj567.jpg
  OR
  $slug = \Helpers::slug_file($filename,'great-doc');
  //hi-how-are-you-muy-good-great-doc.pdf

```

In this function you can specify a new filename (REPLACE) and use the same extension
```php

  $slug = \Helpers::slug_filename('SomeFile.jpg','new-name',0);
  //new-name.jpg
  OR
  $slug = \Helpers::slug_filename($file->getorriginalname(),'new-image',2);
  //new-image-9i.ext
  OR
  $slug = \Helpers::slug_filename($file,'one','great-images');
  //one-great-images.png

```


Here's an example of how to implement the random function, Adds random at the end of the file name, and checks if its numeric or string
```php

  $slug = \Helpers::slug_random('new-image');
  //new-image-hv8

```

Here's an example of how to implement the random function, Adds random at the end of the file name, and checks if its numeric or string
```php

  $slug = \Helpers::slug_username('Hi how are-you? Muy@#$%^&*good');
  //hihoware-youmuygood

```

# Code

Help with pre and code content

```php

  $slug = \Helpers::prepareCode($codeVariable);
  //SEND: <script>xxxx</script>
  //RETURNS: &lt;script>xxxx&lt;/script>

```

# Social Sharing
$url can be null to automatically get the current url page

### Facebook Share
$app_id is optional
```php
  {{\Helpers::facebookshare($url,$title,$app_id)}}
```

### Twitter Share
$username is optional
```php
  {{\Helpers::twittershare($url,$title,$username)}}
```

### LinkedIn Share
$username is optional
```php
  {{\Helpers::linkedinshare($url,$title,$username)}}
```

### Pinterest Share
$image is optional
```php
  {{\Helpers::pinterestshare($url,$title,$image)}}
```

### Whatsapp Share
```php
  {{\Helpers::whatsappshare($url,$text)}}
```

### Whatsapp Chat
```php
  {{\Helpers::whatsappchat($phone,$url,$text)}}
  //\Helpers::whatsappchat('15551234xxx',null,'Im interested in your service')
```

### ADD POPUP INSTEAD OF target="_blank"
Just add to the link onclick="return popup(this);"
```php
  {!!\Helpers::popup()!!}
```
```js
  onclick="return popup(this);"
```

### GET CURRENT PAGE URL
```php
  {!!\Helpers::currenturl()!!}
```


### ALTENATIVE SLUG
```php
  $slug = \Helpers::altSlug($slugs, $lang, $principal='en');
```

### ALTENATIVE LANG
```php
  $altLang = \Helpers::alternateLang($lang, $langs=false);
```

### MINIFY HTML
```php
  $html = \Helpers::minify_html($html);
```


### DOWNLOAD GOOGLE FONT
Example url: "https://fonts.googleapis.com/css2?family=Playfair:ital,opsz,wght@0,5..1200,300..900;1,5..1200,300..900&display=swap"
```php
  $html = \Helpers::gFonts($url);
```



### PROCESS INSTAGRAM SCRAPER
Requires https://github.com/postaddictme/instagram-php-scraper composer require raiym/instagram-php-scraper
```php
  $media = \Helpers::instagram_process($instagram,'username');
```