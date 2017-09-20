<?php

namespace Priotas\Twig\Extension;

use Endroid\QrCode\QrCode as EndroidQrcode;

class QrCode extends \Twig_Extension
{
    const DEFAULT_IMAGE_SIZE = 200;
    const DEFAULT_PADDING = 16;

    /**
     * Name of this extension.
     *
     * @return string
     */
    public function getName()
    {
        return 'priotas/qrcode';
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
    public function qrcode(
        $value, 
        $type = EndroidQrcode::IMAGE_TYPE_PNG, 
        $size=self::DEFAULT_IMAGE_SIZE,
        $padding = self::DEFAULT_PADDING,
        $label = '',
        $version=null
        )
    {
        try {
            $qrCode = (new EndroidQrcode())
                ->setImageType($type)
                ->setLabel($label)
                ->setPadding((int) $padding)
                ->setSize((int) $size)
                ->setText($value)
                ->setVersion($version);
            $dataUrl = $qrCode->getDataUri();
        } catch (\Exception $e) {
            throw $e;
        }

        return $dataUrl;
    }
}
