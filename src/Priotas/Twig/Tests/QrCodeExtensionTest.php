<?php

namespace Priotas\Twig\Tests;

use PHPUnit\Framework\TestCase;
use Priotas\Twig\Extension\QrCode;

class QrcodeExtensionTest extends TestCase
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
        $this->assertRegExp('/data:image\/png;base64,[a-zA-Z0-9+\/]+={0,2}$/', $result);
    }

    /**
     * @return void
     */
    public function testValidImageTypes()
    {
        $validTypes = ['png' => 'png', 'svg' => 'svg+xml', 'eps' => 'eps'];

        foreach ($validTypes as $writer => $prefix) {
            $template = sprintf('{{ "moooooo"|qrcode(type="%s") }}', $writer);
            $result = $this->processify($template);
            $this->assertStringStartsWith(sprintf('data:image/%s;base64', $prefix), $result);
        }
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
        $svg1 = '{{ "moooooo"|qrcode(size=400,type="svg") }}';
        $result = $this->processify($svg1);
        $this->assertStringStartsWith('data:image/svg+xml;base64', $result);

        $svg2 = '{{ "moooooo"|qrcode(type="svg",size=400) }}';
        $result2 = $this->processify($svg2);
        $this->assertStringStartsWith('data:image/svg+xml;base64', $result2);
    }

    /**
     * @return void
     */
    public function testSetAllAvailableOptions()
    {
        $template = '{{ "moooooo"|qrcode(type="png",size=100,label="Okay",version=20) }}';
        $result = $this->processify($template);
        $this->assertStringStartsWith('data:image/png;base64', $result);
    }

    /**
     * @return void
     */
    public function testSvgMode()
    {
        $template = '{{ "moooooo"|qrcode(type="svg") }}';
        $result = $this->processify($template);
        $this->assertStringStartsWith('data:image/svg+xml;base64', $result);

        $template2 = '{{ "moooooo"|qrcode(type="svg",svg="data_uri") }}';
        $result2 = $this->processify($template2);
        $this->assertStringStartsWith('data:image/svg+xml;base64', $result2);

        $template3 = '{{ "moooooo"|qrcode(type="svg",svg="inline") }}';
        $result3 = $this->processify($template3);
        $this->assertStringStartsWith('<svg', $result3);
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
