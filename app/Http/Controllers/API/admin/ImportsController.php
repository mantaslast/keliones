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

    public function parsePlainCsv(Request $request)
    {
        $keysMap = array(
            'price' => ['kaina', 'kaina (€)', 'price'],
            'name' => ['pavadinimas', 'name'],
            'country' => ['salis', 'šalis', 'country'],
            'city' => ['miestas', 'city'],
            'discount' => ['nuolaida', 'discount'],
            'leave_at' => ['leave_at', 'isvykimas', 'išvykimas'],
            'arrive_at' => ['atvykimas', 'atvykimo data', 'arrive_at'],
            'description' => ['aprasymas', 'aprašymas','apibudinimas', 'apibūdinimas', 'description'],
            'category' => ['category', 'kategorija']
        );

        $columnsMap = [];
        $notFoundColumns = [];
        $offers = [];
        $columnsByIndex = [];

        $files = [];
        if ($request->file('files')) {
            $files = $request->file('files');
        }

        foreach($files as $key => $file) {
            $csvPath = $file->path();
            $csv = new CsvIterator($csvPath);
            foreach ($csv as $key => $row) {
                //Debugginimui ar aptinka CSV columnus
                // dd($row);
                if ($key == 1) {
                    foreach($row as $index => $item) {
                        $found = false;
                        foreach($keysMap as $column => $values) {
                            if (in_array(trim(mb_strtolower($item, 'UTF-8')), $values)) {
                                $columnsMap[$column] = $index;
                                $found = true;
                                break;
                            }
                        }
                        if ($found == false) {
                            $notFoundColumns[] = $item;
                        }
                    }
                    $columnsOfCsv = array_values($columnsMap); // panaudojamu stulpeliu indexai
                    $columnsByIndex = array_flip($columnsMap);
                }

                if (count($columnsOfCsv) < 1) {
                    return json_encode(['success' => false]);
                }
                if ($key > 1) {
                    $offer = [];
                    foreach($columnsOfCsv as $columnIndex) {
                        $offer[$columnsByIndex[$columnIndex]] = $row[$columnIndex];
                    }
                    $offers[] = $offer;
                }
            }
        }
        
        
        //Paskutinis pasiulymas visad buna nulliniais elementais, todel popinam
        array_pop($offers);
        $successfullOffers = [];
        $failedOffers = [];
        foreach($offers as $key => $offer) {
            try {
                $newOffer = array(
                    'name' => $offer['name'] ?? '',
                    'country' => $offer['country'] ?? '',
                    'city' => $offer['city'] ?? '',
                    'price' => $offer['price'] ?? '',
                    'discount' => $offer['discount'] ?? '',
                    'leave_at' => \DateTime::createFromFormat('d/m/Y', $offer['leave_at'])->format('Y-m-d') ?? '',
                    'arrive_at' => \DateTime::createFromFormat('d/m/Y', $offer['arrive_at'])->format('Y-m-d') ?? '',
                    'description' => $offer['description'] ?? '',
                    'hidden' => 1,
                    'imported' => 1,
                    'images'=>'',
                    'category' => $offer['category'] ?? ''
                );
                $successfullOffers[] = $newOffer;
            } catch (Exception $e) {
                $failedOffers[] = $offer;
            }
        }

        // dd([
        //     'success' => $successfullOffers, 
        //     'failed' => $notFoundColumns, 
        //     'rejected' => $failedOffers,
        //     'column_names' => array_values($columnsByIndex),
        // ]);


        // return response()->json([
        //     'success' => $this->convert_from_latin1_to_utf8_recursively($successfullOffers), 
        //     'failed' => $this->convert_from_latin1_to_utf8_recursively($notFoundColumns), 
        //     'rejected' => $this->convert_from_latin1_to_utf8_recursively($failedOffers),
        //     'column_names' => $this->convert_from_latin1_to_utf8_recursively(array_values($columnsByIndex)),
        // ]);


        return json_encode([
            'success' => $successfullOffers, 
            'failed' => $notFoundColumns, 
            'rejected' => $failedOffers,
            'column_names' => array_values($columnsByIndex),
        ]);
    }

    public function storeScrappedImportedOffer(Request $request)
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

    public function storePlainImportedOffer(Request $request)
    {
        $data = $request->data;
        
        $offer = array(
            'name' => $data['name'] ?? '',
            'country' => $data['country'] ?? '',
            'city' => $data['city'] ?? '',
            'price' => $data['price'] ?? '',
            'discount' => $data['discount'] ?? '',
            'leave_at' => $data['leave_at'] ?? '',
            'arrive_at' => $data['arrive_at'] ?? '',
            'description' => $data['description'] ?? '',
            'hidden' => 1,
            'imported' => 1,
            'images'=>''
        );

        $offer = new Offer($offer);
        
        if (isset($data['category'])) {
            $offer->category()->associate($data['category']);
        } else {
            $offer->category()->associate(1);
        }

        $offer->save();
        
        return json_encode(['succ' => true, 'data' => $data]);
    }
}
