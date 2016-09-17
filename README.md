# A Twig extension for rendering inline text as qrcodes

[![Build Status](https://travis-ci.org/priotas/twig-qrcode-extension.svg?branch=master)](https://travis-ci.org/priotas/twig-qrcode-extension)

```
<!-- index.html.twig -->
<!DOCTYPE html>
<html>
    <body>

        <img src="{{ 'http://kewl.example.com' | qrcode(size=200) }}" />
    
    </body>
</html>
```