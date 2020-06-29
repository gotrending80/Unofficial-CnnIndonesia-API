<?php

namespace CnnIndonesia;

use PHPHtmlParser\Dom as HtmlParser;

use CnnIndonesia\Model\Article;
use CnnIndonesia\Model\ArticleDetail;
use CnnIndonesia\Exception\CnnDomException;
use CnnIndonesia\Endpoints;
use CnnIndonesia\NewsHomePart;

class Cnn
{
    const HTTP_NOT_FOUND        = 404;
    const HTTP_OK               = 200;
    const HTTP_INTERNAL_ERROR   = 500;

    private $dom;

    public function __construct()
    {
        // ini_set('display_errors', 1);

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
        switch($news_part) {
            case NewsHomePart::HEADLINE_NEWS:
                return $this->headline_news();
            case NewsHomePart::FEATURED_NEWS:
                return $this->featured_news();
            case NewsHomePart::BOX_NEWS:
                return $this->box_news();
            case NewsHomePart::LATEST_NEWS:
                return $this->latest_news();
            case NewsHomePart::LATEST_COVID:
                return $this->latest_covid();
            case NewsHomePart::VIDEO_NEWS:
                return $this->video_news();
            case NewsHomePart::POPULAR_NEWS:
                return $this->popular_news();
            case NewsHomePart::COLUMNIST:
                return $this->columnist();
            default:
                return $this->toJson(
                    array(
                        'status'    => static::HTTP_NOT_FOUND,
                        'message'   => 'Error: invalid parameter input.'
                    )
                );
        }
    }

    /**
     * get headline news
     * 
     * @return array
     */
    private function headline_news()
    {
        $this->dom->load(Endpoints::BASE_URL);
        
        $articles       = array();
        $articles_raw   = array();

        $main_article   = $this->dom->find('article.big_hl a');
        $list_article   = $this->dom->find('.playlist_wrap .playlist .media_rows article a');

        array_push($articles_raw, $main_article);

        foreach($list_article as $article_raw) {
            array_push($articles_raw, $article_raw);
        }

        $articles = $this->generateArticles($articles_raw);
        
        return $this->toJson(
            array(
                'status'        => static::HTTP_OK,
                'type'          => 'headline_news',
                'total_data'    => count($articles),
                'data'          => $articles
            )
        );
    }

    /**
     * get featured news
     * 
     * @return array
     */
    private function featured_news()
    {
        $this->dom->load(Endpoints::BASE_URL);

        $articles       = array();
        $articles_raw   = $this->dom->find('#content #slide_bu article a');

        $articles = $this->generateArticles($articles_raw);

        return $this->toJson(
            array(
                'status'        => 200,
                'type'          => 'featured_news',
                'total_data'    => count($articles),
                'data'          => $articles
            )
        );
    }

    /**
     * get box news
     * 
     * @return array
     */
    private function box_news()
    {

    }

    /**
     * get article detail
     * 
     * @example $url => https://www.cnnindonesia.com/nasional/20200628021802-20-518242/penularan-corona-di-tulungagung-makin-cepat
     * @param string $url
     */
    public function detail($url)
    {
        $this->dom->load($url);

        $news_detail_dom        = $this->dom->find('.l_content .content_detail');
        
        if (count($news_detail_dom) == 0) {
            throw new \Exception('Error : Dom not found');
        }

        $article_detail                     = new ArticleDetail;
        $article_detail->author             = explode('|', trim($news_detail_dom->find('div.date')->text))[0];
        $article_detail->author             = trim($article_detail->author);
        $article_detail->sub_category       = $news_detail_dom->find('a.gtm_breadcrumb_subkanal')->text;
        $article_detail->content            = strip_tags($news_detail_dom->find('#detikdetailtext')->innerHtml, '<p>');
        $article_detail->published_date     = explode('|', trim($news_detail_dom->find('div.date')->text))[1];
        $article_detail->published_date     = trim($article_detail->published_date);
        $article_detail->image_text         = $news_detail_dom->find('.media_artikel span')->text;

        return $this->toJson(
            array(
                'status'        => static::HTTP_OK,
                'type'          => 'detail',
                'data'          => $article_detail->output()
            )
        );
    }

    /**
     * get full article detail
     * 
     * @param string $url
     */
    public function full_detail($url)
    {

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