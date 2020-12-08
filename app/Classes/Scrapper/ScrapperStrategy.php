<?php

namespace App\Classes\Scrapper;

interface ScrapperStrategy
{
    public function scrape(String $url);
}