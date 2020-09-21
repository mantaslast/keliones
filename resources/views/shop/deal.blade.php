@extends('layouts.shop.app', ['title' => $offer->name, 'offer' => $offer])

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="title text-center my-3">{{ $offer->name }}</h1>
            <h2 class="deal_location text-center"><i class="fas fa-map-marker-alt mr-2"></i>{{ $offer->country }} , {{ $offer->city }}</h2>
            <div class="deal_card">
                <div class="deal_images">
                    <div class="item small">
                        <div class="deal_image small" style="background-image:url('/files/{{ json_decode($offer->images)[0] }}');"></div>
                        <div class="deal_image small" style="background-image:url('/files/{{ json_decode($offer->images)[1] }}');"></div>
                    </div>
                    <div class="item big">
                        <div class="deal_image big" style="background-image:url('/files/{{ json_decode($offer->images)[2] }}');"></div>
                    </div>
                </div>
                <div class="deal_info_wrapper my-3">
                    <div class="deal_name">{{ $offer->name }}</div>
                    <div class="deal_info_item_wrapper">
                        <div class="deal_info_label">Išvykimo data:</div>
                        <div class="deal_info_item ml-2">{{ $offer->leave_at }}</div>
                    </div>
                    <div class="deal_info_item_wrapper">
                        <div class="deal_info_label">Atvykimo data:</div>
                        <div class="deal_info_item ml-2">{{ $offer->arrive_at }}</div>
                    </div>
                </div>
                <div class="deal_info_wrapper my-1">
                    <div class="deal_info_item_wrapper bottom">
                        <div class="deal_price">{{ $offer->price }} &euro;</div>
                        <div class="deal_discount ml-3">{{ $offer->discount + $offer->price}} &euro;</div>
                        <a href="{{ route('reservation', ['offer' => $offer->id]) }}" class="deal_reserve btn-primary ml-4">Rezervuoti</a>
                    </div>
                </div>
            </div>

            <div class="deal_card mt-4">
                <div class="deal_description">
                {!! $offer->description !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
