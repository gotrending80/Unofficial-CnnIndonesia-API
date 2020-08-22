<?php

namespace News;

use News\AbstractNewsFactory;

class CnnIndonesiaFactory extends AbstractNewsFactory {

    private $context    = 'CnnIndonesia';

    public function generateArticles() {
        return new CnnIndonesiaNews;
    }
    
}