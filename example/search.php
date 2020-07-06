<?php

require __DIR__ . '/../vendor/autoload.php';

$cnn            = new \CnnIndonesia\Cnn();

$keyword        = $_GET['keyword'];
$category       = isset($_GET['category']) ? $_GET['category'] : '';
$date           = isset($_GET['date']) ? $_GET['date'] : '';
$page           = isset($_GET['page']) ? $_GET['page'] : 1;

echo $cnn->search($keyword, $category, $date, $page);