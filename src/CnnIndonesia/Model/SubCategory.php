<?php

namespace CnnIndonesia\Model;

/**
 * Class Category
 * @package Cnn\Models
 */
class SubCategory
{
    /**
     * url
     * @var string
     */

    private $url;

    /**
     * name
     * @var string
     */
    private $name;

    /**
     * empty constructor
     */
    public function __construct(string $url, string $name)
    {
        $this->url      = $url;
        $this->name     = $name;
    }

    public function output() {
        return array(
            'url'   => $this->url,
            'name'  => $this->name
        );
    }
}