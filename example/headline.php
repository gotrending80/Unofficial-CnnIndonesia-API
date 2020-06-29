<?php

require __DIR__ . '/../vendor/autoload.php';

$cnn = new \CnnIndonesia\Cnn();
echo $cnn->headline();