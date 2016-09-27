[![Build Status](https://travis-ci.org/priotas/twig-qrcode-extension.svg?branch=master)](https://travis-ci.org/priotas/twig-qrcode-extension)

# Overview

+ A Twig extension for embedding inline QR codes in Twig templates.
+ The standard filter output is a [DataURL](https://developer.mozilla.org/en-US/docs/Web/HTTP/Basics_of_HTTP/Data_URIs) string of the processed text.


```
composer require priotas/twig-qrcode-extension
```


```html
<!-- index.html.twig -->
<!DOCTYPE html>
<html>
    <body>

        <img src="{{ 'http://kewl.example.com' | qrcode(size=200) }}" />
    
    </body>
</html>
```

```php

use Priotas\Twig\Extension\QrCode;

$loader = new \Twig_Loader_Filesystem(__DIR__);
$twig = new \Twig_Environment($loader);
$twig->addExtension(new QrCode());

echo $twig->render('index.html.twig');
```

<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOgAAADoAQMAAADfZzo7AAAABlBMVEX///8AAABVwtN+AAAACXBIWXMAAA7EAAAOxAGVKw4bAAAAzElEQVRYhe2VUQ7DMAhDff9Le2vACdV2gtcSKY38+AJDpTfg4YrvQ+saCpP2fSEXvek86qVe3xKjwGml6Cn0lINOc3uf31kA0d5d4/zZdRyayDa7qzw6PV8mWHkG02F17/ZTqcrr3fxjfWNpGt8laMtTqXuwnYeSxKQtqffYnnFx6SqAFZ/LuyRIetqe5F0bJFWVo42edSYqTdIYbTLNDyqSUxsqvd3uagyz4+hxt2fQqRufcWdTjQUe6yPpFDw2GpS2t2t7H0Slb4DjA6OJxrgh+lL8AAAAAElFTkSuQmCC" />

# Available filter options

| Option        |Type    |Default  | Description  |
| ------------- |--------|---------| -------------|
| type          |string  |png      | The image type. Available types are png, gif, jpeg, wbmp |
| label         |string  |         | A label for the QR code  |
| padding       |integer |16       | The padding around the QR code |
| size          |integer |200      | The size of the QR code |
| version       |integer |auto     | The version of the QR code. Range 1-40 |


# Dependencies

+ https://github.com/endroid/QrCode
+ http://php.net/manual/en/book.image.php
+ http://twig.sensiolabs.org/
