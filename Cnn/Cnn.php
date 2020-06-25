<?php

use Cnn\Exception\NewsTitleH1Exception;
use \Carbon\Carbon;

class CNN_Indonesia
{
    private $dom;

    private $url;

    public function __construct($php_html_parser)
    {
        ini_set('display_errors', 1);

        $this->dom = $php_html_parser;
        $this->url = 'https://www.cnnindonesia.com/';
    }


    /**
     * method to get headline news
     * 
     * @return array
     */
    public function headline()
    {
        $this->dom->load($this->url);
        
        $headlines      = array();
        $headlines_raw  = array();

        $main_headline  = $this->dom->find('article.big_hl a');
        $list_headline  = $this->dom->find('.playlist_wrap .playlist .media_rows article a');

        array_push($headlines_raw, $main_headline);

        foreach($list_headline as $headline_raw) {
            array_push($headlines_raw, $headline_raw);
        }

        foreach($headlines_raw as $headline) {
            $item_headline                      = array();
            $item_headline['url']          = $headline->getAttribute('href');
            $item_headline['image_url']    = $headline->find('img')->getAttribute('src');
            $item_headline['title']        = 
                (count($headline->find('h1.title')) > 0) ?
                $headline->find('h1.title')->text :
                $headline->find('h2.title')->text;
            $item_headline['category']     = $headline->find('span.kanal')->text;
            $item_headline['created_at']         = $this->handleDate($headline->find('span.date')->text);
            
            array_push($headlines, $item_headline);
        }
        
        return $this->toJson(
            array(
                'status'        => 200,
                'type'          => 'headline',
                'total_data'    => count($headlines),
                'data'          => $headlines
            )
        );
    }

    /**
     * method to get berita_utama news
     * 
     * @return array
     */
    public function berita_utama()
    {

    }

    /**
     * get covid info
     * 
     * @return array
     */
    public function covid()
    {

    }

    /**
     * get the new news
     * 
     * @return array
     */
    public function new_news()
    {
        
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
     * handle time ago so it will return timestamp
     * 
     * @param string $time_ago
     * 
     * @return string
     */
    private function handleDate($time_ago)
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
    private function toJson($data)
    {
        header('Content-Type: application/json');
        return json_encode($data);
    }

}