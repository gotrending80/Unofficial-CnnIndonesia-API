<?php

namespace CnnIndonesia;

class Endpoints
{
    const BASE_URL              = 'https://www.cnnindonesia.com/';
    const ARTICLE_URL           = 'https://www.cnnindonesia.com/{category}/{created_at}-{category_id}-{article_id}/{title}';
    const SEARCH_URL            = 'https://www.cnnindonesia.com/search?query={keyword}&kanal={category}&date={date}&p={page}&query={keyword}';
    const ALL_NEWS_URL          = 'https://www.cnnindonesia.com/indeks/{page}?date={date}&kanal=2';

    public static function getArticleUrlLink($category, $createdAt, $categoryId, $articleId, $title) {
        $articleUrl     = str_replace('{category}', $category, static::ARTICLE_URL);
        $articleUrl     = str_replace('{created_at}', $createdAt, static::ARTICLE_URL);
        $articleUrl     = str_replace('{category_id}', $categoryId, static::ARTICLE_URL);
        $articleUrl     = str_replace('{article_id}', $articleId, static::ARTICLE_URL);
        $articleUrl     = str_replace('{category}', $title, static::ARTICLE_URL);
        
        return $articleUrl;
    }

    public static function getSearchUrlLink($keyword, $category = '', $date = '', $page = '') {
        $search_url     = str_replace('{keyword}',  $keyword,    static::SEARCH_URL);
        $search_url     = str_replace('{category}', $category,  $search_url);
        $search_url     = str_replace('{date}',     $date,      $search_url);
        $search_url     = str_replace('{page}',     $page,      $search_url);

        return $search_url;
    }

    public static function getAllNewsLink($page, $date) {
        $search_url     = str_replace('{page}', $page, static::ALL_NEWS_URL);
        $search_url     .= str_replace('{date}', $page, $search_url);

        return $search_url;
    }
}