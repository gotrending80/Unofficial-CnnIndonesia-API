<?php
// $my_email = "name@company.com";
// if (preg_match("/^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/", $my_email)) {
//     echo "$my_email is a valid email address";
// } else {
//     echo "$my_email is NOT a valid email address";
// }

$url = 'https://www.cnnindonesia.com/olahraga/20200627091637-142-518086/ronaldo-terus-kejar-immobile-di-daftar-top-skor-liga-italia';
$list = array();
$result = preg_match("/-+[0-9]{3}/", $url, $list);
print_r($list);
?>