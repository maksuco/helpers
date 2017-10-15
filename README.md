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

Get data for a chartxxxx

```php

  \Helpers::xxxxx($biz_id,$table,$date,$sum);
  
```


# Device check

Reponse with the correct device, example: (300,'table',200), the response is 300 when is mobile

```php

  \Helpers::agent($mobile,$table,$desktop);
  
```


## Security

If you discover any security related issues, please report it.

## Credits
- [Maksuco.com](http://maksuco.com)
- [ReBilling.co](https://rebilling.co)

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
