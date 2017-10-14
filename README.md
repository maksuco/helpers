# Analytics Helpers

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


Get the dates from today minus....
$period = 'month','day','year','all'
$period2 = 1,2,3, etc..

```php

  \Helpers::period($period,$period2);

```


Get the visits and pageviews
$path = /someurl/blogname

```php

  \Helpers::counter($period,$period2,$path);

```


Get the visits and pageviews for Charts
$path = /someurl/blogname
return [$visitors,$pageviews,$labels];

```php

  \Helpers::chart($period,$period2,$path);
  
```


Get the visits and pageviews for Charts

```php

  \Helpers::charts($data1);
  
```


Get the $count and $sum of 2 fields per table

```php

  \Helpers::reports($biz_id,$table,$count,$sum);
  
```


## Security

If you discover any security related issues, please report it.

## Credits
- [Maksuco.com](http://maksuco.com)
- [ReBilling.co](https://rebilling.co)

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
