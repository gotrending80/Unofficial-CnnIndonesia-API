<?php

require __DIR__ . '/../vendor/autoload.php';

$cnn        = new \CnnIndonesia\Cnn();
$news_url   = $_GET['news_url'];
echo $cnn->detail($news_url);