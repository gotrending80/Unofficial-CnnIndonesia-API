<?php

require __DIR__ . '/../vendor/autoload.php';

$cnn        = new \CnnIndonesia\Cnn();
$mode       = isset($_GET['mode']) ? $_GET['mode'] : 'default';
echo $cnn->get_categories($mode);