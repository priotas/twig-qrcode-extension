<?php

namespace Priotas\Twig\Tests;

use Priotas\Twig\Extensions\QrCode;

class QrcodeExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return void
     */
    public function testExtensionName()
    {
        $qrcode = new QrCode();
        $this->assertEquals('qrcode', $qrcode->getName());
    }

    public function testSimpleQrcode()
    {
        $template = '{{ "moooooo"|qrcode }}';
        $result = $this->processify($template);
        $this->assertStringStartsWith('data:image/png;base64', $result);
    }

    public function testValidImageTypes()
    {
        $png = '{{ "moooooo"|qrcode(type="png") }}';
        $result = $this->processify($png);
        $this->assertStringStartsWith('data:image/png;base64', $result);

        $gif = '{{ "moooooo"|qrcode(type="gif") }}';
        $result = $this->processify($gif);
        $this->assertStringStartsWith('data:image/gif;base64', $result);

        $jpeg = '{{ "moooooo"|qrcode(type="jpeg") }}';
        $result = $this->processify($jpeg);
        $this->assertStringStartsWith('data:image/jpeg;base64', $result);
        
        $wbmp = '{{ "moooooo"|qrcode(type="wbmp") }}';
        $result = $this->processify($wbmp);
        $this->assertStringStartsWith('data:image/wbmp;base64', $result);
    }

    /**
     * @expectedException \Twig_Error_Runtime
     */
    public function testInvalidImageType()
    {
        $lol = '{{ "moooooo"|qrcode(type="lol") }}';
        $result = $this->processify($lol);
    }

    public function parametersOrderingDoesNotMatter()
    {
        $wbmp = '{{ "moooooo"|qrcode(size=400,type="wbmp") }}';
        $result = $this->processify($wbmp);
        $this->assertStringStartsWith('data:image/wbmp;base64', $result);
    }

    private function processify($template, $data = array()) {
        $twig = $this->twigify($template);
        $result = $twig->render('template', $data);
        return $result;
    }

    private function twigify($template) {
        $loader = new \Twig_Loader_Array(array(
            'template' => $template,
        ));
        $twig = new \Twig_Environment($loader);
        $twig->addExtension(new QrCode());
        return $twig;
    }
}
