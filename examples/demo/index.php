<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Priotas\Twig\Extensions\QrCode;

$loader = new \Twig_Loader_Filesystem(__DIR__);
$twig = new \Twig_Environment($loader);
$twig->addExtension(new QrCode());

echo $twig->render('index.html.twig');
