<?php

namespace Priotas\Twig\Extensions;

use Endroid\QrCode\QrCode as EndroidQrcode;

class Qrcode extends \Twig_Extension
{
    /**
     * Name of this extension.
     *
     * @return string
     */
    public function getName()
    {
        return 'qrcode';
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return array(
            'qrcode' => new \Twig_SimpleFilter(
                'qrcode', array($this, 'qrcode'), array('pre_escape' => 'html', 'is_safe' => array('html'))
            ),
        );
    }

    /**
     * @return string
     */ 
    public function qrcode($value, $size=300, $type = EndroidQrcode::IMAGE_TYPE_PNG)
    {        
        try {
            $qrCode = (new EndroidQrcode())
                ->setImageType($type)
                ->setSize($size)
                ->setText($value);
            $data =\base64_encode($qrCode->get());
        } catch(\Exception $e) {
            throw $e;   
        }
        
        $dataUrl = 'data:image/%s;base64,%s'; 

        return sprintf($dataUrl, $type, $data);
    }
}