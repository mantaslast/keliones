<?php

namespace App\Http\Controllers\WEB\admin\offers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Offer;
use App\Category;
use App\Http\Requests\offer\StoreOffer;
use Illuminate\Support\Str;
use PDF;


class OffersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $offers = Offer::where('hidden', 0)->get();

        return view('admin.offers.index', ['offers' => $offers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.offers.create', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOffer $request)
    {
        $validated = $request->validated();

        $data = [];
        if($request->imgs) {
            foreach($request->imgs as $file)
            { 
                $data[] = $file;  
            }
         }
    
        $filenames=json_encode($data);
        $validated['images'] = $filenames;

        $offer = new Offer($validated);
        $offer->category()->associate(Category::find($validated['category_id']));
        $offer->save();

        return redirect()->back()->withSuccess('Sėkmingai sukurtas pasiūlymas!'); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $offer = Offer::findOrFail($id);

        return view('admin.offers.offer', ['offer' => $offer]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = Category::all();
        $offer = Offer::findOrFail($id);

        return view('admin.offers.edit', ['offer' => $offer, 'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreOffer $request, $id)
    {
        $validated = $request->validated();
     
        $data = [];

        if($request->imgs) {
            foreach($request->imgs as $file)
            { 
                $data[] = $file;  
            }
        }

        $filenames=json_encode($data);        
        $validated['images'] = $filenames;
        $validated['hidden'] = 0;
        $offer = Offer::findOrFail($id);
        $offer->update($validated);

        return redirect()->back()->withSuccess('Sėkmingai atnaujintas pasiūlymas!'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $offer = Offer::findOrFail($id);
        $offer->delete();

        return redirect()->back();
    }

    public function generatePdf()
    {
        $offers = Offer::all();
        
        view()->share('admin.offers.pdf',$offers);
        $pdf = PDF::loadView('admin.offers.pdf', compact('offers'));

        return $pdf->stream('pdf_file.pdf');
    }

    public function getImports()
    {
        return view('admin.offers.imports');
    }

    public function getImported()
    {
        $offers = Offer::where('hidden', 1)->get();

        return view('admin.offers.index', ['offers' => $offers]);
    }
}
