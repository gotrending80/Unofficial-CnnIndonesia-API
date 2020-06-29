<?php

namespace CnnIndonesia\Model;

// https://stat.detik.com/detikanalytic/__dtm.gif?
// dtmwv=3.0&
// dtmn=1400978848&
// dtmdt=Kronologi%20RUU%20HIP%20Versi%20Baleg%3A%20Trisila%20Muncul%20di%20Tengah%20Jalan&dtmhn=www.cnnindonesia.com&
// dtmp=/nasional/20200626201313-32-518019/kronologi-ruu-hip-versi-baleg-trisila-muncul-di-tengah-jalan&
// dtmf=93f5920f58cc82a96e5676fd5839c37a&dtma=136467298.1641051412.1593014075.1593062233.1593221761.3&
// dtmb=136467298.5.10.1593223843&
// dtmr=&
// createddate=1593223503000&
// articleid=518019&
// kanalid=32&
// custom_title=kronologi%20ruu%20hip%20versi%20baleg:%20trisila%20muncul%20di%20tengah%20jalan&custom_type=detail&
// custom_pagetype=text&
// dtmac=acc-cnnindonesia&
// dtmacsub=desktop&
// namakanal=nasional&
// custom_pagetype=singlepage&
// articledewasa=dewasatidak&
// articlehoax=default&
// publishdate=1593223503000&
// contenttype=singlepagenews&
// videopresent=No&
// keywords=ruu%20hip%2C%20kontroversi%20ruu%20hip&
// thumbnailUrl=https%3A%2F%2Fakcdn.detik.net.id%2Fvisual%2F2020%2F06%2F24%2Fdemo-tolak-ruu-hip-21_169.jpeg%3Fw%3D650&
// createddate_str=2020%2F06%2F26%2020%3A13%3A13&
// publishdate_str=2020%2F06%2F27%2009%3A05%3A03&
// createddate_ori=1593177193000

/**
 * Class Article
 * @package Cnn\Models
 */
class Article
{

    /**
     * ID
     * @var int
     */
    public $id;

    /**
     * Title
     * @var string
     */
    public $title;

    /**
     * Url
     * @var string
     */
    public $url;

    /**
     * Image Url
     * @example => https://akcdn.detik.net.id/visual/2020/02/18/7dd8600e-6d40-415f-a592-25b4ab41c618_169.jpeg?q=100
     * @var string
     */
    public $image_url;

    /**
     * Category
     * @var string
     */
    public $category;

    /**
     * Created At
     * @var string
     */
    public $created_at;

    /**
     * Timestamp
     * @var string
     */
    public $timestamp;

    /**
     * Category ID
     * @var string
     */
    public $category_id;

    /**
     * empty constructor
     */
    public function __construct() {}

    /**
     * return the article
     * 
     * @return array
     */
    public function output() {
        return $this;
    }

    // /**
    //  * init the article
    //  * 
    //  * @param int $id
    //  * @param string $title
    //  * @param string $url
    //  * @param string $imageUrl
    //  * @param string $category
    //  * @param string $createdAt
    //  */
    // public function init(
    //     int $id, 
    //     string $title, 
    //     string $url, 
    //     string $imageUrl, 
    //     string $category, 
    //     string $createdAt) 
    // {
    //     $this->id               = $id;
    //     $this->title            = $title;
    //     $this->url              = $url;
    //     $this->imageUrl         = $imageUrl;
    //     $this->category         = $category;
    //     $this->createdAt        = $createdAt;
    // }

    // /**
    //  * set the article detail
    //  * @param ArticleDetail $articleDetail
    //  */
    // public function setArticleDetail(ArticleDetail $articleDetail)
    // {
    //     $this->articleDetail    = $articleDetail;
    // }

    // /**
    //  * set the id
    //  * @param int $id
    //  */
    // public function setId(int $id)
    // {
    //     $this->id               = $id;
    // }

    // /**
    //  * set the title
    //  * @param string $title
    //  */
    // public function setTitle(string $title)
    // {
    //     $this->title            = $title;
    // }

    // /**
    //  * set the url
    //  * @param string $url
    //  */
    // public function setUrl(string $url)
    // {
    //     $this->url              = $url;
    // }

    // /**
    //  * set the image url
    //  * @param string $imageUrl
    //  */
    // public function setImageUrl(string $imageUrl)
    // {
    //     $this->imageUrl         = $imageUrl;
    // }

    // /**
    //  * set the category
    //  * @param string $category
    //  */
    // public function setCategory(string $category)
    // {
    //     $this->category         = $category;
    // }

    // /**
    //  * set the created at
    //  * @param string $createdAt
    //  */
    // public function setCreatedAt(string $createdAt)
    // {
    //     $this->createdAt         = $createdAt;
    // }

    // /**
    //  * get the id
    //  * @return int $id
    //  */
    // public function getId()
    // {
    //     return $this->id;
    // }

    // /**
    //  * get the title
    //  * @return string $title
    //  */
    // public function getTitle()
    // {
    //     return $this->title;
    // }

    // /**
    //  * get the url
    //  * @return string $url
    //  */
    // public function getUrl()
    // {
    //     return $this->url;
    // }

    // /**
    //  * get the image url
    //  * @return string $imageUrl
    //  */
    // public function getImageUrl()
    // {
    //     return $this->imageUrl;
    // }

    // /**
    //  * get the category
    //  * @return string $category
    //  */
    // public function getCategory()
    // {
    //     return $this->category;
    // }

    // /**
    //  * get the created at
    //  * @return string $createdAt
    //  */
    // public function getCreatedAt()
    // {
    //     return $this->createdAt;
    // }

    // /**
    //  * get the article detail
    //  * @return ArticleDetail $articleDetail
    //  */
    // public function getArticleDetail()
    // {
    //     return $this->articleDetail;
    // }
}