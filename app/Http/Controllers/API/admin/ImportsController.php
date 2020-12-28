<?php

namespace App\Http\Controllers\Api\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Classes\Csv\CsvIterator;
use App\Classes\Scrapper\Scrapper;
use App\Offer;

class ImportsController extends Controller
{
    
    private $domains = ['www.guliveriokeliones.lt','guliveriokeliones.lt', 'beta.lt','www.beta.lt','www.makalius.lt','makalius.lt'];
    public function parseScrapperCsv(Request $request)
    {
        $files = [];
        if ($request->file('files')) {
            $files = $request->file('files');
        }
        $successFullLinks = 0;
        $rejectedLinks = [];
        $urls = [];
        foreach($files as $key => $file) {
            $csvPath = $file->path();
            $csv = new CsvIterator($csvPath);
            foreach ($csv as $key => $row) {
                if ($key > 1 && $row[0] !== NULL) {
                    $url = $row[0];
                    if (filter_var($url, FILTER_VALIDATE_URL) === FALSE) {
                        $rejectedLinks[] = $url;
                    } else {
                        $domain = parse_url($url, PHP_URL_HOST);
                        if (in_array($domain, $this->domains)) {
                            $successFullLinks++;
                            $urls[] = $url;
                        }
                    }
                }
            }
        }

        $dataArr = [];
        $failedLinks = [];
        foreach ($urls as $key => $url) {
            try {
                $domain = parse_url($url, PHP_URL_HOST);
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
                $dataArr[] = $data;
            } catch (\InvalidArgumentException $e) {
                $failedLinks[] = $url;
            }
        }

        return json_encode([
                'success' => $dataArr, 
                'failed' => $failedLinks, 
                'rejected' => $rejectedLinks
            ]);
    }

    public function parsePlainCsv()
    {

    }

    public function storeImportedOffer(Request $request)
    {
        $data = $request->data;
        
        $offer = array(
            'name' => $data['name'],
            'country' => '',
            'city' => '',
            'price' => $data['price'],
            'discount' => 0,
            'leave_at' => $data['leave_at'],
            'arrive_at' => $data['arrive_at'],
            'description' => $data['description'],
            'hidden' => 1,
            'imported' => 1,
            'images'=>''
        );
       
        $offer = new Offer($offer);
        $offer->category()->associate(1);
        $offer->save();
        
        return json_encode(['succ' => true, 'data' => $data]);
    }
}
