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

Get data for a chart Report, same as before, but this returns 'total_sum', 'total_count', 'date', 'sum' and 'count' so you can use it in charts datasets

```php

  $chart = \Helpers::reports_chart($biz_id,$table,$date,$field);
  {!! $chart['sum'] !!}
  
```


# Device check: Mobile, Tables, Desktop

Reponse with the correct device, example: (300,'table',200), the response is 300 when is mobile

```php

  \Helpers::agent($mobile,$table,$desktop);
  
  
```

# Avatar

This function helps you show the user avatar or the gravatar, just send the user array or email.

In your env file specify "SHOWAVATAR_PATH"

```php

  $slug = \Helpers::avatar($user);
  OR
  $slug = \Helpers::avatar($user->email);

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

Here's an example of how to implement the filename function, in this function you can specify the new filename and use the same extension

```php

  $slug = \Helpers::slug_filename('SomeFile@#$%^&*good.png','main-image',0);
  //main-image.ext
  OR
  $slug = \Helpers::slug_filename($file->getorriginalname(),'main-image',2);
  //main-image-9i.ext
  OR
  $slug = \Helpers::slug_filename($file,'one','great-images');
  //one-great-images.png

```

Here's an example of how to implement the random function, in this function you can specify the new filename and use the same extension

```php

  $slug = \Helpers::slug_filename('SomeFile@#$%^&*good.png','main-image',0);
  //main-image.ext
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


## Security

If you discover any security related issues, please report it.

## Credits
- [Maksuco.com](http://maksuco.com)
- [ReBilling.co](https://rebilling.co)

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
