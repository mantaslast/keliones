<?php

namespace App\Http\Controllers\API\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Offer;
use PDF;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class OffersController extends Controller
{
    public function destroy(Request $request)
    {
        try{
            $id = $request->id;
            $offer = Offer::findOrFail($id);
            $offer->delete();
            return json_encode(['success' => 1]);
        } catch(Exception $e) {
            return json_encode(['success' => 0]);
        }
    }

    public function generatePdf(Request $request)
    {
        $offers = $request->offers;
        array_shift($offers);
        view()->share('admin.offers.pdf',$offers);
        $pdf = PDF::loadView('admin.offers.pdf', compact('offers'));

        return $pdf->stream('pdf_file.pdf');
    }

    public function addOfferImage(Request $request)
    {
        if($request->hasfile('file')) {
            $file = $request->file('file');
            $name = Str::random(10).time().'.'.$file->extension();
            $file->move(public_path().'/files/', $name);
        }

        return json_encode(['name' => $name]);
    }

    public function deleteOfferImage(Request $request)
    {
        $filename = $request->name;
        File::delete(public_path("files/".$filename));

        return json_encode($request->name);
    }
    
    public function getOfferImage(Request $request)
    {
        $returnFiles = [];
        $filenames = $request->filenames;
        foreach($filenames as $key => $filename) {
            $file = File::get(public_path('files/'.$filename));
            return (json_encode($file));
        }


        return json_encode($filenames);
    }
}
