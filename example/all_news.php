<?php

require __DIR__ . '/../vendor/autoload.php';

$cnn        = new \CnnIndonesia\Cnn();
$page       = isset($_GET['page']) ? $_GET['page'] : 1;
$date       = isset($_GET['date']) ? $_GET['date'] : '';

echo $cnn->allNews($page, $date);