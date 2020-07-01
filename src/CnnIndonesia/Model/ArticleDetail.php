<?php

namespace CnnIndonesia\Model;

class ArticleDetail
{

    /**
     * Article id (full)
     * @var string
     */
    public $id;

    /**
     * Article title (full)
     * @var string
     */
    public $title;

    /**
     * Author
     * @var string
     */
    public $author;

    /**
     * Category (full)
     * @var string
     */
    public $category;

    /**
     * Content
     * @var string
     */
    public $content;

    /**
     * Image url (full)
     * @var string
     */
    public $image_url;

    /**
     * Image text
     * @var string
     */
    public $image_text;

    /**
     * Sub category
     * @var string
     */
    public $sub_category;

    /**
     * Published date
     * @var string
     */
    public $published_date;

    /**
     * Created at (full)
     * @var string
     */
    public $created_at;

    /**
     * timestamp (full)
     * @var string
     */
    public $timestamp;

    /**
     * category_id (full)
     * @var string
     */
    public $category_id;

    /**
     * url (full)
     * @var string
     */
    public $url;

    /**
     * empty constructor
     */
    public function __construct() {}

    /**
     * output of the article detail
     * 
     * @return array
     */
    public function output()
    {
        unset($this->url);
        unset($this->category_id);
        unset($this->created_at);
        unset($this->image_url);
        unset($this->title);
        unset($this->id);
        unset($this->category);
        unset($this->timestamp);
        return $this;
    }

    /**
     * output fo the article full mode
     * 
     * @return ArticleDetail
     */
    public function output_full()
    {
        return $this;
    }
}