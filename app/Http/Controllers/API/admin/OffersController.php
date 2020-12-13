<?php

namespace App\Http\Controllers\API\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Offer;


class OffersController extends Controller
{
    public function destroy(Request $request)
    {
        try{
            $id = $request->id;
            $offer = Offer::findOrFail($id);
            // $offer->delete();
            return json_encode(['success' => 1]);
        } catch(Exception $e) {
            return json_encode(['success' => 0]);
        }
       
    }
}
