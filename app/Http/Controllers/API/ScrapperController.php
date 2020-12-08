<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Classes\Scrapper\Scrapper;

class ScrapperController extends Controller
{
    public function get(Request $request)
    {
        $domain = parse_url($request->url, PHP_URL_HOST);
        $url = $request->url;
         //return json_encode(['url' => $url, 'domain' => $domain]);
        
        switch($domain) {
            case ('www.guliveriokeliones.lt'):
            case ('guliveriokeliones.lt'):
                $scrapper = new Scrapper(new \App\Classes\Scrapper\GuliverisScrapperStrategy());
                break;
            case ('beta.lt'):
            case ('www.beta.lt'):
                $scrapper = new Scrapper(new \App\Classes\Scrapper\BetaScrapperStrategy());
                break;
            case ('www.makalius.lt'):
            case ('makalius.lt'):
                $scrapper = new Scrapper(new \App\Classes\Scrapper\MakaliusScrapperStrategy());
                break;
            default:
                return json_encode(['errors' => 1]);
        }

        $data = $scrapper->executeScrapper($url);

        return json_encode($data);
    }
}
