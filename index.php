<?php

header('Content-Type: application/json');
echo json_encode(
    array(
        'status'    => 200,
        'message'   => 'Welcome to Unnoficial CNN Indonesia API'
    )
);