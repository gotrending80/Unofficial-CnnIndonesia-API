<?php

require __DIR__ . '/../vendor/autoload.php';

$cnn        = new \CnnIndonesia\Cnn();
$type  = $_GET['type'];

echo $cnn->latest_covid($type);