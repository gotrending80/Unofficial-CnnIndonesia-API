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

    // /**
    //  * init the article detail
    //  * 
    //  * @param string $author
    //  * @param string $content
    //  * @param string $imageText
    //  * @param string $subCategory
    //  * @param string $publishedDate
    //  */
    // public function init($author, $content, $imageText, $subCategory, $publishedDate)
    // {
    //     $this->author           = $author;
    //     $this->content          = $content;
    //     $this->imageText        = $imageText;
    //     $this->subCategory      = $subCategory;
    //     $this->publishedDate    = $publishedDate;
    // }

    // /**
    //  * set the author
    //  * @param string $author
    //  */
    // public function setAuthor(string $author)
    // {
    //     $this->author               = $author;
    // }

    // /**
    //  * set the content
    //  * @param string $content
    //  */
    // public function setContent(string $content)
    // {
    //     $this->content              = $content;
    // }

    // /**
    //  * set the image text
    //  * @param string $imageText
    //  */
    // public function setImageText(string $imageText)
    // {
    //     $this->imageText            = $imageText;
    // }

    // /**
    //  * set the sub category
    //  * @param string $subCategory
    //  */
    // public function setSubCategory(string $subCategory)
    // {
    //     $this->subCategory          = $subCategory;
    // }

    // /**
    //  * set the published date
    //  * @param string $publishedDate
    //  */
    // public function setPublishedDate(string $publishedDate)
    // {
    //     $this->publishedDate         = $publishedDate;
    // }

    // /**
    //  * get the author
    //  * @return string $author
    //  */
    // public function getAuthor()
    // {
    //     return $this->author;
    // }

    // /**
    //  * get the content
    //  * @return string $content
    //  */
    // public function getContent()
    // {
    //     return $this->content;
    // }

    // /**
    //  * get the image text
    //  * @return string $imageText
    //  */
    // public function getImageText()
    // {
    //     return $this->imageText;
    // }

    // /**
    //  * get the sub category
    //  * @return string $subCategory
    //  */
    // public function getSubCategory()
    // {
    //     return $this->subCategory;
    // }

    // /**
    //  * get the published date
    //  * @return string $publishedDate
    //  */
    // public function getPublishedDate()
    // {
    //     return $this->publishedDate;
    // }

}