<?php

namespace App\Classes\Scrapper;

use App\Classes\Scrapper\ScrapperStrategy;

class Scrapper
{
    private $strategy;

    public function __construct(ScrapperStrategy $strategy)
    {
        $this->strategy = $strategy;
    }

    public function setStrategy(ScrapperStrategy $strategy)
    {
        $this->strategy = $strategy;
    }

    public function executeScrapper(String $url)
    {
        return $this->strategy->scrape($url);
    } 
}