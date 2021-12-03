<?php

namespace Priotas\Twig\Extension;

use Endroid\QrCode\Exception\ValidationException;
use Endroid\QrCode\Factory\QrCodeFactory;
use Exception;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class QrCode extends AbstractExtension
{
    const DEFAULT_IMAGE_SIZE = 200;
    const DEFAULT_TYPE = 'png';
    const SVG_OUTPUT_INLINE = 'inline';
    const SVG_OUTPUT_DATA_URI = 'data_uri';

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return [
            new TwigFilter('qrcode', [$this, 'qrcode'])
        ];
    }

    /**
     * @return string
     * @throws ValidationException|Exception
     */
    public function qrcode(
        $text,
        $type = self::DEFAULT_TYPE,
        $size = self::DEFAULT_IMAGE_SIZE,
        $label = '',
        $version = null,
        $svg = self::SVG_OUTPUT_DATA_URI
    ) {
        $options = [
            'writer' => $type,
            'label' => $label,
            'size' => $size
        ];

        $factory = new QrCodeFactory();
        $qrCode = $factory->create($text, $options);

        if ($type !== 'svg') {
            return $qrCode->writeDataUri();
        }

        switch ($svg) {
            case self::SVG_OUTPUT_DATA_URI:
                return $qrCode->writeDataUri();
            case self::SVG_OUTPUT_INLINE:
                $text = $qrCode->writeString();
                return substr($text, strpos($text, "\n") + 1);
            default:
                throw new \InvalidArgumentException(
                    sprintf('The svg options can either be "%s" or "%s"', self::SVG_OUTPUT_DATA_URI, self::SVG_OUTPUT_INLINE)
                );
        }

    }
}
