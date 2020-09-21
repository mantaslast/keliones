@extends('layouts.shop.app', ['title' => 'Rezervacija'])

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="card bg-dark text-white my-3">
        <img style="max-height:400px;" class="card-img" src="/files/{{ json_decode($order->offer->images)[0] }}" alt="Card image">
            <div class="card-img-overlay">
                <h5 class="card-title">{{$order->key}}</h5>
                <p class="card-text">{{ $order->offer->name }}</p>
                <p class="card-text">{{ $order->getStatus() }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
