# Helpers

This package helps manage analytics and counts.


## Installation

This packages requires Spatie/Analytics for the charts
You can install the package via composer:
``` bash
$ composer require maksuco/Helpers
OR
$ composer require maksuco/Helpers:dev-master
```
This Package works with autodiscovery in Laravel +5.5, but is compatible with older versions

## Usage

# Device check: Mobile, Tables, Desktop

Reponse with the correct device, example: (300,'table',200), the response is 300 when is mobile OR ('mobile','mobile','desktop')

```php

  \Helpers::agent($mobile,$table,$desktop);
  
  
```

# Avatar

This function helps you show the user avatar or the gravatar, just send the user array or email.

In your env file specify "SHOWAVATAR_PATH"

```php

  $img = \Helpers::avatar($user);
  OR
  {{\Helpers::avatar($user->email)}}

```


# Crypto

Here's an example of how to implement crypto to transform strings to hashed keys, using 2 security keys (one set in the .env and another inside the controller, example the $user->id):

```php

  BEFORE
  $security = Helpers::encrypt($string,$key);
  AFTER
  $string = Helpers::decrypt($security,$key);

```

# Slugs

Here's an example of how to implement the slug function to transform names to slugs:

```php

  $slug = \Helpers::slug('Hi how are you? Muy@#$%^&*good');
  //hi-how-are-you-muy-good
  OR
  $slug = \Helpers::slug($name);

```

Here's an example of how to implement the file function to transform file names, the second argument specifies a random addon at the end

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

Here's an example of how to implement the filename function, in this function you can specify a new filename (REPLACE)   (REPLACE) and use the same extension

```php

  $slug = \Helpers::slug_filename('SomeFile.jpg','new-image',0);
  //new-image.jpg
  OR
  $slug = \Helpers::slug_filename($file->getorriginalname(),'main-image',2);
  //main-image-9i.ext
  OR
  $slug = \Helpers::slug_filename($file,'one','great-images');
  //one-great-images.png

```


Here's an example of how to implement the random function, Adds random at the end of the file name, and checks if its numeric or string
```php

  $slug = \Helpers::slug_random('SomeFile');
  //SomeFile-hv8

```

# Active Navigation Page

Send the current page name, example 'about' or 'contactenos', it checks if theres a variable named $active (send from the controller) then checks if the route has a name and then checks the first segment of the page, example: about/history

```php

  {{\Helpers::active($page)}}
  //echo 'active'

```

# Location

Get the country, language and other data from the IP:

```php

  $location_data = \Helpers::location($ip);

```

# Links

Check if a domain doesn't have the http and add it, and other links, domains helpers

```php

  {{\Helpers::link($account->domain)}}
  //http://somedomain.com

```

```php

  $domain = \Helpers::domain_from_email($email);
  //get the domain from an email if it's not a free service like gmail.com, else it returns false

```

```php

  if(\Helpers::domain_check($email)) {}
  //gets the domain from the email and checks if it exist
  OR
  if(\Helpers::domain_check('maksuco.com')) {}
  //Checks if the domain exist

```


# Analytics Helpers

Analytics:Get the dates from today minus....
$period = 'month','day','year','all'
$period2 = 1,2,3, etc..

```php

  \Helpers::period($period,$period2);

```


Analytics:Get the visits and pageviews
$path = /someurl/blogname

```php

  \Helpers::counter($period,$period2,$path);

```


Analytics:Get the visits and pageviews for Charts
$path = /someurl/blogname
return [$visitors,$pageviews,$labels];

```php

  \Helpers::chart($period,$period2,$path);
  
```


Analytics:Get the visits and pageviews for Charts

```php

  \Helpers::charts($data1);
  
```


# Reports

Get the $count and $sum of 2 fields per table, the date field is the one to be used, example: created_at

```php

  \Helpers::reports($biz_id,$table,$date,$sum);
  
```

Get data for a chart Report, same as before, but this returns 'total_sum', 'total_count', 'date', 'sum' and 'count' so you can use it in charts data sets

```php

  $chart = \Helpers::reports_chart($biz_id,$table,$date,$field);
  {!! $chart['sum'] !!}
  
```




## Security

If you discover any security related issues, please report it.

## Credits
- [Maksuco.com](http://maksuco.com)
- [ReBilling.co](https://rebilling.co)

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
