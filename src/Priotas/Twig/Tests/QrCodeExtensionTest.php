<?php

namespace Priotas\Twig\Tests;

use Priotas\Twig\Extension\QrCode;

class QrcodeExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return void
     */
    public function testExtensionName()
    {
        $qrcode = new QrCode();
        $this->assertEquals('priotas/qrcode', $qrcode->getName());
    }

    /**
     * @return void
     */
    public function testSimpleQrcode()
    {
        $template = '{{ "http://kewl.example.com"|qrcode(size=200) }}';
        $result = $this->processify($template);
        $this->assertEquals($result, 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOgAAADoAQMAAADfZzo7AAAABlBMVEX///8AAABVwtN+AAAACXBIWXMAAA7EAAAOxAGVKw4bAAAAzElEQVRYhe2VUQ7DMAhDff9Le2vACdV2gtcSKY38+AJDpTfg4YrvQ+saCpP2fSEXvek86qVe3xKjwGml6Cn0lINOc3uf31kA0d5d4/zZdRyayDa7qzw6PV8mWHkG02F17/ZTqcrr3fxjfWNpGt8laMtTqXuwnYeSxKQtqffYnnFx6SqAFZ/LuyRIetqe5F0bJFWVo42edSYqTdIYbTLNDyqSUxsqvd3uagyz4+hxt2fQqRufcWdTjQUe6yPpFDw2GpS2t2t7H0Slb4DjA6OJxrgh+lL8AAAAAElFTkSuQmCC');
    }

    /**
     * @return void
     */
    public function testValidImageTypes()
    {
        $validTypes = ['png', 'gif', 'jpeg', 'wbmp'];

        \array_walk($validTypes, function ($value) {
            $template = sprintf('{{ "moooooo"|qrcode(type="%s") }}', $value);
            $result = $this->processify($template);
            $this->assertStringStartsWith(sprintf('data:image/%s;base64', $value), $result);
        });
    }

    /**
     * @expectedException \Twig_Error_Runtime
     */
    public function testInvalidImageType()
    {
        $lol = '{{ "moooooo"|qrcode(type="lol") }}';
        $result = $this->processify($lol);
    }

    /**
     * @return void
     */
    public function testParametersOrderingDoesNotMatter()
    {
        $wbmp = '{{ "moooooo"|qrcode(size=400,type="wbmp") }}';
        $result = $this->processify($wbmp);
        $this->assertStringStartsWith('data:image/wbmp;base64', $result);

        $wbmp2 = '{{ "moooooo"|qrcode(type="wbmp",size=400) }}';
        $result2 = $this->processify($wbmp2);
        $this->assertStringStartsWith('data:image/wbmp;base64', $result2);
    }

    /**
     * @return void
     */
    public function testSetAllAvailableOptions()
    {
        $template = '{{ "moooooo"|qrcode(type="png",size=100,padding=20) }}';
        $result = $this->processify($template);
         $this->assertStringStartsWith('data:image/png;base64', $result);
    }

    /**
     * @return string
     */
    private function processify($template, $data = array())
    {
        $twig = $this->twigify($template);
        $result = $twig->render('template', $data);
        return $result;
    }

    /**
     * @return \Twig_Environment
     */
    private function twigify($template)
    {
        $loader = new \Twig_Loader_Array(array(
            'template' => $template,
        ));
        $twig = new \Twig_Environment($loader);
        $twig->addExtension(new QrCode());
        return $twig;
    }
}
