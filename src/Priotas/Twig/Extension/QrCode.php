<?php

namespace Priotas\Twig\Extension;

use Endroid\QrCode\Factory\QrCodeFactory;

class QrCode extends \Twig_Extension
{
    const DEFAULT_IMAGE_SIZE = 200;
    const DEFAULT_TYPE = 'png';
    const SVG_OUTPUT_INLINE = 'inline';
    const SVG_OUTPUT_DATA_URI = 'data_uri';

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
                'qrcode',
                array($this, 'qrcode'),
                array('pre_escape' => 'html', 'is_safe' => array('html'))
            ),
        );
    }

    /**
     * @return string
     */
    public function qrcode(
        $text,
        $type = self::DEFAULT_TYPE,
        $size = self::DEFAULT_IMAGE_SIZE,
        $label = '',
        $version = null,
        $svg = self::SVG_OUTPUT_DATA_URI
        ) {
        try {
            $data = '';
            $options = [
                'writer' => $type,
                'label' => $label
            ];
            $factory = new QrCodeFactory();
            $qrCode = $factory->create($text, $options);
            if ($type === 'svg') {
                if ($svg === self::SVG_OUTPUT_DATA_URI) {
                    $data = $qrCode->writeDataUri();
                } elseif ($svg === self::SVG_OUTPUT_INLINE) {
                    $text = $qrCode->writeString();
                    $data = substr($text, strpos($text, "\n")+1);
                } else {
                    throw new \InvalidArgumentException(
                        sprintf('The svg options can either be "%s" or "%s"', self::SVG_OUTPUT_DATA_URI, self::SVG_OUTPUT_INLINE)
                    );
                }
            } else {
                $data = $qrCode->writeDataUri();
            }
        } catch (\Exception $e) {
            throw $e;
        }

        return $data;
    }
}
