<?php

namespace News;

abstract class AbstractNewsFactory {

    abstract function generateArticles();

    abstract function generateCategories();

    abstract function searchArticle($keyword);

}