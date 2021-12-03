<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Priotas\Twig\Extension\QrCode;
use \Twig\Loader\FilesystemLoader;
use \Twig\Environment;

$url = isset($_POST['url']) ? filter_var($_POST['url'], FILTER_SANITIZE_URL) : null;

$loader = new FilesystemLoader(__DIR__);
$twig = new Environment($loader);
$twig->addExtension(new QrCode());

echo $twig->render('index.html.twig', ['url' => $url]);
