# Analytics Helpers

This package helps manage analytics and counts.


## Installation

You can install the package via composer:
``` bash
$ composer require maksuco/getanalitycs
OR
$ composer require maksuco/getanalitycs:dev-master
```
This Package works with autodiscovery in Laravel +5.5, but is compatible with older versions

## Usage


Get the dates from today minus....
$period = 'month','day','year','all'
$period2 = 1,2,3, etc..

```php

  \GetAnalitycs::period($period,$period2);

```


Get the visits and pageviews
$path = /someurl/blogname

```php

  \GetAnalitycs::counter($period,$period2,$path);

```


Get the visits and pageviews for Charts
$path = /someurl/blogname
return [$visitors,$pageviews,$labels];

```php

  \GetAnalitycs::chart($period,$period2,$path);
  
```


Get the visits and pageviews for Charts

```php

  \GetAnalitycs::charts($data1);
  
```


## Security

If you discover any security related issues, please report it.

## Credits
- [Maksuco.com](http://maksuco.com)
- [ReBilling.co](https://rebilling.co)

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
