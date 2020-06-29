<?php

use Cnn\Exception\NewsTitleH1Exception;
use \Carbon\Carbon;

class CNN_Indonesia
{
    private $_dom;

    private $_url;

    public function __construct($php_html_parser)
    {
        ini_set('display_errors', 1);

        $this->_dom = $php_html_parser;
        $this->_url = 'https://www.cnnindonesia.com/';
    }


    /**
     * method to get headline news
     * 
     * @return array
     */
    public function headline()
    {
        $this->_dom->load($this->url);
        
        $headlines      = array();
        $headlines_raw  = array();

        $main_headline  = $this->_dom->find('article.big_hl a');
        $list_headline  = $this->_dom->find('.playlist_wrap .playlist .media_rows article a');

        array_push($headlines_raw, $main_headline);

        foreach($list_headline as $headline_raw) {
            array_push($headlines_raw, $headline_raw);
        }

        foreach($headlines_raw as $headline) {
            $item_headline                 = array();
            $item_headline['url']          = $headline->getAttribute('href');
            $item_headline['image_url']    = $headline->find('img')->getAttribute('src');
            $item_headline['title']        = 
                (count($headline->find('h1.title')) > 0) ?
                $headline->find('h1.title')->text :
                $headline->find('h2.title')->text;
            $item_headline['category']     = $headline->find('span.kanal')->text;
            $item_headline['created_at']   = $this->_handleDate($headline->find('span.date')->text);
            
            array_push($headlines, $item_headline);
        }
        
        return $this->_toJson(
            array(
                'status'        => 200,
                'type'          => 'headline',
                'total_data'    => count($headlines),
                'data'          => $headlines
            )
        );
    }

    /**
     * method to get main_news news
     * 
     * @return array
     */
    public function main_news()
    {
        $this->_dom->load($this->_url);

        $berita_utamas  = array();
        $articles_raw   = $this->_dom->find('#content #slide_bu article');

        foreach($articles_raw as $article) {
            $item_article               = array();
            $item_article['url']        = $article->find('a')->getAttribute('href');
            $item_article['image_url']  = $article->find('a img')->getAttribute('src');
            $item_article['title']      = $article->find('h2.title')->text;

            array_push($berita_utamas, $item_article);
        }

        return $this->_toJson(
            array(
                'status'        => 200,
                'type'          => 'berita_utama',
                'total_data'    => count($berita_utamas),
                'data'          => $berita_utamas
            )
        );
    }

    /**
     * get box news from home page
     * 
     * @return array
     */
    public function box_news()
    {
        $this->_dom->load($this->_url);

        $box_news     = array();
        $box_news_raw = $this->_dom->find('#content .l_content .cb_ms_large');

        foreach ($box_news_raw as $box_news_item) {
            $title_raw                  = $box_news_item->find('.show_red_line span.cb_title');
            $articles_raw               = $box_news_item->find('.pd15 article');
            $item_box                   = array();

            foreach($articles_raw as $article_item) {
                $item_box['headline_title'] = $title_raw->text;    
                $item_box['url']            = $articles_raw->find('a')->getAttribute('href');
                $item_box['image_url']      = $articles_raw->find('a img')->getAttribute('src');
                $item_box['title']          = $articles_raw->find('h2.title')->text;
                $item_box['category']       = $articles_raw->find('span.kanal')->text;

                if (count($articles_raw->find('span.date')) > 0) {
                    $item_box['created_at']     = $this->_handleDate($articles_raw->find('span.date')->text);
                }

                array_push($box_news, $item_box);
            }
        }

        return $this->_toJson(
            array(
                'status'        => 200,
                'type'          => 'covid_home',
                'total_data'    => count($box_news),
                'data'          => $box_news
            )
        );
    }

    /**
     * get the updated news
     * 
     * @return array
     */
    public function updated_news()
    {
        $this->_dom->load($this->_url);

        return $this->find('#content .berita_terbaru_lst .list article');
    }

    /**
     * get the popular news
     * 
     * @return array
     */
    public function popular()
    {

    }

    /**
     * get the kolumnis
     * 
     * @return array
     */
    public function kolumnis()
    {

    }

    /**
     * get the indeks
     * type => Semua, Nasional, Internasional, Ekonomi, Olahraga, Teknologi, Hiburan, Gaya Hidup
     * @param string $category
     * 
     * @return array
     */
    public function indeks($category)
    {

    }

    /**
     * handle article tag on home page
     * 
     * @param string $dom_to_article
     * 
     * @return string
     */
    private function _handleArticleTags($dom_to_article)
    {
        
    }
    

    /**
     * handle time ago so it will return timestamp
     * 
     * @param string $time_ago
     * 
     * @return string
     */
    private function _handleDate($time_ago)
    {
        $filter     = trim(str_replace('&bull;', '', trim($time_ago)));
        $time_en    = '';

        $time       = explode(' ', $filter);
        $time_num   = $time[0];

        if (strpos($filter, 'detik') !== false) {
            $time_postfix   = ($time_num > 1) ? 'seconds'   : 'second';
            $time_en        = str_replace('detik',  $time_postfix, $filter);
        } else if (strpos($filter, 'menit') !== false) {
            $time_postfix   = ($time_num > 1) ? 'minutes'   : 'minute';
            $time_en        = str_replace('menit',  $time_postfix, $filter);
        } else if (strpos($filter, 'jam') !== false) {
            $time_postfix   = ($time_num > 1) ? 'hours'     : 'hour';
            $time_en        = str_replace('jam',    $time_postfix, $filter);
        } else if (strpos($filter, 'hari') !== false) {
            $time_postfix   = ($time_num > 1) ? 'days'      : 'day';
            $time_en        = str_replace('hari',   $time_postfix, $filter);
        } else if (strpos($filter, 'minggu') !== false) {
            $time_postfix   = ($time_num > 1) ? 'weeks'     : 'week';
            $time_en        = str_replace('minggu', $time_postfix, $filter);
        } else {
            throw new Exception('handleData errors.');
        }

        $time_en            = str_replace('yang lalu', 'ago', $time_en);
        $result_datetime    = Carbon::parse($time_en, 'Asia/Jakarta');

        return $result_datetime->toDateTimeString();
    }

    /**
     * convert result to json
     * 
     * @param array $data
     * 
     * @return json
     */
    private function _toJson($data)
    {
        header('Content-Type: application/json');
        return json_encode($data);
    }

}