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

use Illuminate\Support\Facades\Crypto;

```

# Device check: Mobile, Tables, Desktop

Response with the correct device, example: (300,'table',200), the response is 300 when is mobile OR 200 if it's desktop. ('mobile','table','desktop')

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

# First Name

Helps you show the user first name, from a full name, max lenth of the returned name is 11

```php

  {{\Helpers::firstname($fullname)}}
  //Gina Gutierrez returns Gina
  //Gi Gutierrez returns Gi Gutierrez

```


# Crypto

Here's an example of how to implement crypto to transform strings to hashed keys, using 2 security keys (one set in the .env and another inside the controller, example the $user->id):

```php

  //SEND
  $security = Helpers::encrypt($string,$key);
  //AFTER
  $string = Helpers::decrypt($string,$key);

```

# Slugs

Here's an example of how to implement the slug function to transform names to slugs:

```php

  $slug = \Helpers::slug('Hi how are you? Muy@#$%^&*good');
  //RETURNS: hi-how-are-you-muy-good
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

Here's an example of how to implement the filename function, in this function you can specify a new filename (REPLACE) and use the same extension

```php

  $slug = \Helpers::slug_filename('SomeFile.jpg','new-image',0);
  //new-image.jpg
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

# Active Navigation Page

Send the current page name, example 'about' or 'contactenos', it checks if theres a variable named $active (send from the controller) then checks if the route has a name and then checks the first segment of the page, example: about/history

```php

  {{\Helpers::nav_active($page)}}
  //SEND: nav_active('about')
  //RETURNS: 'active'

```

# Text parser

 Convert plain text to include real html links

```php

  {{\Helpers::text_parse($text)}}
  //SEND: Welcome to http:://apple.com
  //RETURNS: Welcome to <a href="http:://apple.com">http:://apple.com</a>

```

# Location

Get the country, language and other data from the IP:

```php

  $location_data = \Helpers::location($ip);

```

# Links

Check if a domain doesn't have the http and adds it, and other links, domains helpers

```php

  {{\Helpers::link($account->domain)}}
  //SEND: somedomain.com
  //RETURNS: http://somedomain.com

```

```php

  $domain = \Helpers::domain_from_email($email);
  //returns the domain from an email if it's not a free service like gmail.com, else it returns false

```

```php

  if(\Helpers::domain_check($email)) {}
  //returns the domain from the email and checks if it exist
  OR
  if(\Helpers::domain_check('maksuco.com')) {}
  //Checks if the domain exist

```

