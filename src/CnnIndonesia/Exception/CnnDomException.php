<?php

namespace Cnn\Exception;

class CnnDomException extends \Exception {

    public function __construct($message = '', $code = 500, $previous = null) 
    {
        parent::__construct($message, $code, $previous);
    }

}