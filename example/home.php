<?php

require __DIR__ . '/../vendor/autoload.php';

$cnn        = new \CnnIndonesia\Cnn();
$news_part  = $_GET['news_part'];

echo $cnn->home($news_part); // get the headline news