@extends('layouts.shop.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="title text-center">Kelionė į palangą</div>
            <div class="deal_location text-center"><i class="fas fa-map-marker-alt mr-2"></i>Lietuva, Poilsis prie jūros, Palanga</div>
            <div class="deal_card">
                <div class="deal_images">
                    <div class="item small">
                        <div class="deal_image small" style="background-image:url('https://ipsumimage.appspot.com/360x240');"></div>
                        <div class="deal_image small" style="background-image:url('https://ipsumimage.appspot.com/360x240');"></div>
                    </div>
                    <div class="item big">
                        <div class="deal_image big" style="background-image:url('https://ipsumimage.appspot.com/510x500');"></div>
                    </div>
                </div>
                <div class="deal_info_wrapper my-3">
                    <div class="deal_name">Poilsis Palangoje</div>
                    <div class="deal_info_item_wrapper">
                        <div class="deal_info_label">Išvykimo data:</div>
                        <div class="deal_info_item ml-2">2020-05-05</div>
                    </div>
                    <div class="deal_info_item_wrapper">
                        <div class="deal_info_label">Atvykimo data:</div>
                        <div class="deal_info_item ml-2">2020-05-05</div>
                    </div>
                </div>
                <div class="deal_info_wrapper my-1">
                    <div class="deal_info_item_wrapper bottom">
                        <div class="deal_price">100 &euro;</div>
                        <div class="deal_discount ml-3">100 &euro;</div>
                        <button class="deal_reserve btn-primary ml-4">Rezervuoti</button>
                    </div>
                </div>
            </div>

            <div class="deal_card mt-4">
                <div class="deal_description">
                Lorem ipsum dolor, sit amet consectetur adipisicing elit. Qui alias asperiores dolore aliquid hic minus ab? Incidunt expedita dolorem ipsa vitae velit similique, sed veniam quasi tenetur pariatur, et voluptatibus!
                Lorem ipsum dolor, sit amet consectetur adipisicing elit. Qui alias asperiores dolore aliquid hic minus ab? Incidunt expedita dolorem ipsa vitae velit similique, sed veniam quasi tenetur pariatur, et voluptatibus!
                Lorem ipsum dolor, sit amet consectetur adipisicing elit. Qui alias asperiores dolore aliquid hic minus ab? Incidunt expedita dolorem ipsa vitae velit similique, sed veniam quasi tenetur pariatur, et voluptatibus!
 Lorem ipsum dolor, sit amet consectetur adipisicing elit. Qui alias asperiores dolore aliquid hic minus ab? Incidunt expedita dolorem ipsa vitae velit similique, sed veniam quasi tenetur pariatur, et voluptatibus!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
