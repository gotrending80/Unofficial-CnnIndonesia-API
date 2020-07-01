<?php

namespace CnnIndonesia\Model;

use CnnIndonesia\Model\SubCategory;
use CnnIndonesia\Model\Article;

/**
 * Class Category
 * @package Cnn\Models
 */
class Category
{
    /**
     * url
     * @var string
     */

    public $url;

    /**
     * name
     * @var string
     */
    public $name;
    
    /**
     * sub category
     * @var SubCategory
     */
    public $sub_categories  = array();

    /**
     * highlight articles
     * @var Article
     */
    public $highlights      = array();

    /**
     * empty constructor
     */
    public function __construct() {}
}