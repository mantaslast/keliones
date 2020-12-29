<?php

namespace App\Classes\Scrapper;

use Goutte\Client;
use GuzzleHttp\Client as GuzzleClient;

class MakaliusScrapperStrategy implements ScrapperStrategy
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
        $i=0;
        try {
            $description = $crawler->filter('.post-single-content')->first()->html();
            $name = $crawler->filter('.offer-top')->children()->first()->text();
            $crawler->filter('.offers-list')->each( function ($subNode) use (&$info, &$i, &$date){
                $date = explode(' ',$subNode->children()->first()->text('default'))[1];
                $subNode->children()->each( function($node) use (&$info, &$i, &$date){
                    if ($node->attr('class') !== 'date') {
                        $price = floatval($node->children()->first()->children()->last()->text('default'));
                        $info[$i]['price'] = $price;
                        $info[$i]['dateTo'] = $date;
                        $i++;
                    }
                });
            });
            
            return ['data' => $info, 'description' => $description, 'name' => $name];
        } catch (Exception $e) {
            return ['errors' => $e];
        }
    }
}