<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Priotas\Twig\Extension\QrCode;

$url = isset($_POST['url']) ? filter_var($_POST['url'], FILTER_SANITIZE_URL) : null;

$loader = new \Twig_Loader_Filesystem(__DIR__);
$twig = new \Twig_Environment($loader);
$twig->addExtension(new QrCode());

echo $twig->render('index.html.twig', ['url' => $url]);
