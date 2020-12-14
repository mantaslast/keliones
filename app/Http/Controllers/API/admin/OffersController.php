<?php

namespace App\Http\Controllers\API\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Offer;
use PDF;
use Storage;

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
}
