<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Goutte\Client;
use GuzzleHttp\Client as GuzzleClient;

class ScrapperController extends Controller
{
    public function get(Request $request)
    {
        $url = $request->url;
        $gouteClient = new Client();
        $guzzleClient = new GuzzleClient(array(
            'timeout' => 60,
        ));
        $gouteClient->setClient($guzzleClient);
        $crawler = $gouteClient->request('GET', $url);
        $info = [];
        try {
            $description = $crawler->filter('.hiddenDescriptionTab')->first()->html();
            $name = $crawler->filter('.inner-deal-header  ')->first()->text();
            $i = 0;
            $crawler->filter('.choice-item')->each( function ($subNode) use (&$info, &$i, $description){
                $dates = explode(' ', $subNode->filter('.smallDate')->text('default'));
                $info[$i]['dateFrom'] = $dates[0];
                $info[$i]['dateTo'] = $dates[1];
                $price = floatval($subNode->filter('.priceField')->text('default'));
                $info[$i]['price'] = $price;
                $i++;
            });

            return json_encode(['data' => $info, 'description' => $description, 'name' => $name]);
        } catch (Exception $e) {
            return json_encode(['errors' => $e]);
        }
    }
}
