<?php

namespace CnnIndonesia;

use Exception;
use PHPHtmlParser\Dom as HtmlParser;

use CnnIndonesia\Model\Article;
use CnnIndonesia\Model\ArticleDetail;
use CnnIndonesia\Model\Category;
use CnnIndonesia\Model\SubCategory;
use CnnIndonesia\Exception\CnnDomException;
use CnnIndonesia\Endpoints;
use CnnIndonesia\Home;

class Cnn
{
    const HTTP_NOT_FOUND        = 404;
    const HTTP_OK               = 200;
    const HTTP_INTERNAL_ERROR   = 500;

    private $dom;

    public function __construct()
    {
        $this->dom = new HtmlParser;
    }

    /**
     * get news from home page
     * 
     * news_part => headline_news, featured_news, box_news, latest_news, latest_covid, video_news
     * 
     * @param string $news_part
     * 
     * @return array
     */
    public function home(string $news_part)
    {
        $this->dom->load(Endpoints::BASE_URL);

        $articles_raw   = array();
        $articles       = array();

        switch($news_part) {
            case Home::HEADLINE_NEWS:
                $main_article   = $this->dom->find('article.big_hl a');
                $list_article   = $this->dom->find('.playlist_wrap .playlist .media_rows article a');

                array_push($articles_raw, $main_article);
                foreach($list_article as $article_raw) { array_push($articles_raw, $article_raw); }

                break;
            case Home::FEATURED_NEWS:
                $articles_raw   = $this->dom->find('#content #slide_bu article a');
                break;
            case Home::BOX_NEWS:
                $articles_raw   = $this->dom->find('#content .l_content .cb_ms_large article a');
                break;
            case Home::LATEST_NEWS:
                $articles_raw   = $this->dom->find('#content .berita_terbaru_lst .list article a');
                break;
            case Home::POPULAR_NEWS:
                $popular        = $this->dom->find('#content div.r_content .box.mb20')[0];
                $articles_raw   = $popular->find('article a');
                break;
            default:
                return $this->toJson(
                    array(
                        'status'    => static::HTTP_NOT_FOUND,
                        'message'   => 'Error: invalid parameter input.'
                    )
                );
        }

        if (count($articles_raw) === 0) {
            return $this->toJson(
                array(
                    'status'    => static::HTTP_NOT_FOUND,
                    'message'   => 'Error: article not found'
                )
            );
        }
        
        $articles = $this->generateArticles($articles_raw);
        
        return $this->toJson(
            array(
                'status'        => static::HTTP_OK,
                'type'          => $news_part,
                'total_data'    => count($articles),
                'data'          => $articles
            )
        );
    }

    /**
     * get article detail
     * 
     * @example $url => https://www.cnnindonesia.com/nasional/20200628021802-20-518242/penularan-corona-di-tulungagung-makin-cepat
     * @param string $url
     */
    public function detail($url, $mode)
    {
        try {
            if ($mode != 'default' && $mode != 'full') {
                throw new Exception('Error : mode is invalid');
            }

            $this->dom->load($url);

            $news_detail_dom        = $this->dom->find('.l_content .content_detail');
            
            if (count($news_detail_dom) === 0) {
                throw new CnnDomException('Error : Dom not found');
            }

            $article_detail                     = new ArticleDetail;
            $article_detail->author             = explode('|', trim($news_detail_dom->find('div.date')->text))[0];
            $article_detail->author             = trim($article_detail->author);
            $article_detail->sub_category       = $news_detail_dom->find('a.gtm_breadcrumb_subkanal')->text;
            $article_detail->content            = strip_tags($news_detail_dom->find('#detikdetailtext')->innerHtml, '<p>');
            $article_detail->published_date     = explode('|', trim($news_detail_dom->find('div.date')->text))[1];
            $article_detail->published_date     = trim($article_detail->published_date);
            $article_detail->image_text         = $news_detail_dom->find('.media_artikel span')->text;

            if ($mode == 'full') {
                $exploded_url                   = $this->explodeArticleUrl($url);

                $article_detail->url            = $exploded_url['url'];
                $article_detail->category_id    = $exploded_url['category_id'];
                $article_detail->created_at     = $exploded_url['created_at'];
                $article_detail->image_url      = $this->handleImageUrl($news_detail_dom->find('.media_artikel img')->getAttribute('src'));
                $article_detail->title          = trim($news_detail_dom->find('h1.title')->text);
                $article_detail->id             = $exploded_url['id'];
                $article_detail->category       = trim($news_detail_dom->find('a.gtm_breadcrumb_kanal')->text);
                $article_detail->timestamp      = $exploded_url['timestamp'];
            }

            return $this->toJson(
                array(
                    'status'        => static::HTTP_OK,
                    'type'          => $mode != 'full' ? 'detail' : 'detail_full',
                    'data'          => $mode != 'full' ? $article_detail->output() : $article_detail->output_full()
                )
            );
        } catch(CnnDomException $cde) {
            return $this->toJson(
                array(
                    'status'        => static::HTTP_NOT_FOUND,
                    'message'       => $cde->getMessage()
                )
            );
        } catch(Exception $e) {
            return $this->toJson(
                array(
                    'status'        => static::HTTP_INTERNAL_ERROR,
                    'message'       => $e->getMessage()
                )
            );
        }
    }

    /**
     * get list of category
     * 
     * @return array
     */
    public function get_categories($mode)
    {
        try {
            if ($mode != 'default' && $mode != 'full') {
                throw new Exception('Error : invalid mode');
            }

            $this->dom->load(Endpoints::BASE_URL);

            $categories     = array();
            $categories_raw = $this->dom->find('#nav_menu li');

            foreach($categories_raw as $key => $nav_item) {
                if ($key == 0) continue;
                $category_raw           = $nav_item->find('a[class*="gtm_navbar"]');

                $category               = new Category;
                $category->url          = $category_raw->getAttribute('href');
                $category->name         = trim($category_raw->text);
                
                if ($mode == 'full') {
                    $sub_category_raw       = $nav_item->find('.col_2 a');
                    $articles_raw           = $nav_item->find('.col_8 .gap article a');

                    foreach($sub_category_raw as $sub_category) {
                        $sub_cat       = new SubCategory(
                            $sub_category->getAttribute('href'),
                            $sub_category->text
                        );
                        array_push($category->sub_categories, $sub_cat->output());
                    }
    
                    $category->highlights   = $this->generateArticles($articles_raw);
                } else {
                    unset($category->sub_categories);
                    unset($category->highlights);
                }
                
                array_push($categories, $category);
            }

            return $this->toJson(
                array(
                    'status'        => static::HTTP_OK,
                    'type'          => 'categories',
                    'total_data'    => count($categories),
                    'data'          => $categories
                )
            );
        } catch(Exception $e) {
            return $this->toJson(
                array(
                    'status'        => static::HTTP_INTERNAL_ERROR,
                    'message'       => $e->getMessage()
                )
            );
        }
    }

    /**
     * get list of sub-category
     * 
     * @return array
     */
    public function get_sub_categories()
    {
        try {
            $this->dom->load(Endpoints::BASE_URL);

            $subcats    = array();
            $subcat_raw = $this->dom->find('#nav_menu li .col_2 a');
            
            foreach($subcat_raw as $subcat) {
                $item_subcat       = new SubCategory(
                    $subcat->getAttribute('href'),
                    $subcat->text
                );
                array_push($subcats, $item_subcat->output());
            }

            return $this->toJson(
                array(
                    'status'        => static::HTTP_OK,
                    'type'          => 'sub_categories',
                    'total_data'    => count($subcats),
                    'data'          => $subcats
                )
            );
        } catch (Exception $e) {
            return $this->toJson(
                array(
                    'status'        => static::HTTP_INTERNAL_ERROR,
                    'message'       => $e->getMessage()
                )
            );
        }
    }

    /**
     * generate article output
     * 
     * @param mixed|Collection|null
     * @return array
     */
    private function generateArticles($articles_dom)
    {
        $articles   = array();

        foreach($articles_dom as $article_item) {
            $article                = new Article;
            $exploded_url           = $this->explodeArticleUrl($article_item->getAttribute('href'));

            $article->url           = $exploded_url['url'];
            $article->id            = $exploded_url['id'];
            $article->title         = (count($article_item->find('h1.title')) > 0) ?
                                        $article_item->find('h1.title')->text :
                                        $article_item->find('h2.title')->text;
            $article->image_url     = $this->handleImageUrl($article_item->find('img')->getAttribute('src'));
            $article->category      = (count($article_item->find('span.kanal')) > 0) ?
                                        $article_item->find('span.kanal')->text :
                                        null;
            $article->created_at    = $exploded_url['created_at'];
            $article->category_id   = $exploded_url['category_id'];
            $article->timestamp     = $exploded_url['timestamp'];

            array_push($articles, $article->output());
        }

        return $articles;
    }

    /**
     * explode article url
     * 
     * @param string $url
     * @return array
     */
    private function explodeArticleUrl($url)
    {
        $restval = array();

        $timestamp_raw  = array();
        $category_raw   = array();
        $id_raw         = array();

        preg_match("/[0-9]{14}/", $url, $timestamp_raw);
        $created_at     = $timestamp_raw[0];

        if (strlen($created_at) != 14) {
            throw new CNNDOMException('Error converting created_at', 500);
        }

        $year           = substr($created_at, 0, 4);
        $month          = substr($created_at, 4, 2);
        $day            = substr($created_at, 6, 2);
        $hour           = substr($created_at, 8, 2);
        $minute         = substr($created_at, 10, 2);
        $second         = substr($created_at, 12, 2);
        $created_at_str = "$year-$month-$day $hour:$minute:$second";

        preg_match("/-+[0-9]{3}/", $url, $category_raw);
        $category_id    = str_replace('-', '', $category_raw[0]);
        if (strlen($category_id) != 3) {
            throw new CNNDOMException('Error converting category_id', 500);
        }

        preg_match("/[0-9]+\//", $url, $id_raw);
        $id             = str_replace('/', '', $id_raw[0]);
        if (strlen($id) != 6) {
            throw new CNNDOMException('Error converting article_id', 500);
        }        

        $restval['url']             = $url;
        $restval['created_at']      = $created_at_str;
        $restval['category_id']     = intval($category_id);
        $restval['id']              = intval($id);
        $restval['timestamp']       = intval($created_at);

        return $restval;
    }

    /**
     * handle article id
     * 
     * @param string $url
     * 
     * @return string
     */
    private function handleArticleId($url)
    {
        $id_raw = array();
        preg_match("/[0-9]+\//", $url, $id_raw);
        $id     = str_replace('/', '', $id_raw[0]);

        if (strlen($id) != 6) {
            throw new CNNDOMException('Error converting article_id', 500);
        }

        return intval($id);
    }

    /**
     * handle created at
     * 
     * @param string $url
     * 
     * @return string
     */
    private function handleCreatedAt($url)
    {
        $timestamp  = array();
        preg_match("/[0-9]{14}/", $url, $timestamp);
        $createdAt  = $timestamp[0];

        if (strlen($createdAt) != 14) {
            throw new CNNDOMException('Error converting created_at', 500);
        }

        $year = substr($createdAt, 0, 4);
        $month = substr($createdAt, 4, 2);
        $day = substr($createdAt, 6, 2);
        $hour = substr($createdAt, 8, 2);
        $minute = substr($createdAt, 10, 2);
        $second = substr($createdAt, 12, 2);

        return "$year-$month-$day $hour:$minute:$second";
    }

    /**
     * handle article image
     * 
     * @param string $imageUrl
     * 
     * @return string
     */
    private function handleImageUrl($imageUrl)
    {
        $splitImageUrl = explode('?', $imageUrl);

        return $splitImageUrl[0] . '?q=100';
    }

    /**
     * convert result to json
     * 
     * @param array $data
     * 
     * @return json
     */
    private function toJson($data)
    {
        header('Content-Type: application/json');
        return json_encode($data);
    }
}