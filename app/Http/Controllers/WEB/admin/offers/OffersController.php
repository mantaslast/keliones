<?php

namespace App\Http\Controllers\WEB\admin\offers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Offer;
use App\Category;
use App\Http\Requests\offer\StoreOffer;

class OffersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $offers = Offer::all();

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
}
