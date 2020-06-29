<?php

namespace CnnIndonesia;

class Endpoints
{
    const BASE_URL      = 'https://www.cnnindonesia.com/';
    const ARTICLE_URL   = 'https://www.cnnindonesia.com/{category}/{created_at}-{category_id}-{article_id}/{title}';

    public static function getArticleUrlLink($category, $createdAt, $categoryId, $articleId, $title) {
        $articleUrl     = str_replace('{category}', $category, static::ARTICLE_URL);
        $articleUrl     = str_replace('{created_at}', $createdAt, static::ARTICLE_URL);
        $articleUrl     = str_replace('{category_id}', $categoryId, static::ARTICLE_URL);
        $articleUrl     = str_replace('{article_id}', $articleId, static::ARTICLE_URL);
        $articleUrl     = str_replace('{category}', $title, static::ARTICLE_URL);
        
        return $articleUrl;
    }
}