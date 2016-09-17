# A Twig extension for rendering inline text as qrcodes

```
<!-- index.html.twig -->
<!DOCTYPE html>
<html>
    <body>

        <img src="{{ 'http://kewl.example.com' | qrcode(size=200) }}" />
    
    </body>
</html>
```