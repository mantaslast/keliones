<?php

namespace App\Classes\Scrapper;

use Goutte\Client;
use GuzzleHttp\Client as GuzzleClient;

class GuliverisScrapperStrategy implements ScrapperStrategy
{
    public function scrape(String $url)
    {
        $gouteClient = new Client();
        $guzzleClient = new GuzzleClient(array(
            'timeout' => 60,
        ));
        $gouteClient->setClient($guzzleClient);
        $crawler = $gouteClient->request('GET', $url);
        $info = [];
        $i = 0;

        try {
            $description = $crawler->filter('.long-description')->text('default');
            $name = $crawler->filter('.entry-title')->text('default');
            $crawler->filter('.travel-dates-list')->children()->each( function ($subNode) use (&$info, &$i) {
                $dates = $subNode->children('.travel-date-col')->text('Default');
                $year = explode('-', explode(' ', $dates)[0])[0];
               

                $info[$i]['dateFrom'] = explode(' ', $dates)[0];
                $info[$i]['dateTo'] = $year.'-'.explode(' ', $dates)[2]; 
                $info[$i]['price'] = floatval($subNode->children('.travel-date-details-col')->children('.date-price')->text('default'));
                $i++;
            });
       
            return ['data' => $info, 'description' => $description, 'name' => $name];
        } catch (Exception $e) {
            return ['errors' => $e];
        }
    }
}