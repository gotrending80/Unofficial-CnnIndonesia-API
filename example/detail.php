<?php

require __DIR__ . '/../vendor/autoload.php';

$cnn        = new \CnnIndonesia\Cnn();
$news_url   = $_GET['news_url'];
$mode       = isset($_GET['mode']) ? $_GET['mode'] : 'default';

echo $cnn->detail($news_url, $mode);