@extends('layouts.shop.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="title text-center">Profilis</div>
            </div>
        </div>
    </div>
    <user-profile :userid="{{ $user->id }}"></user-profile>
    <div class="container">
        <div class="row">
            <div class="col-12">
                @if(count($orders) > 0)
                <div class="title text-center">Užsakymai</div>
                @endif
               <div class="row my-3 orders">
                    @foreach($orders as $order)
                        <div class="card order-card">
                            <div class="statusIcon">
                                @if($order->status == 0)
                                    <i class="far fa-credit-card waitingPaymentOrder" title="Laukiamas apmokėjimas"></i>
                                @elseif($order->status == 1)
                                    <i class="fas fa-exclamation-circle canceledOrder" title="Atšauktas"></i>
                                @elseif($order->status == 2)
                                    <i class="far fa-check-circle successfullOrder" title="Apmokėtas"></i>
                                @else
                                    Įvykęs
                                @endif
                            </div>
                            @if($order->status == 2)
                                <app-order-pdf :orderid="'{{json_encode($order->id)}}'"></app-order-pdf>
                            @endif

                            <img class="card-img-top" src="files/{{ json_decode($order->offer->images)[0] }}" alt="Card image cap">
                            <div class="card-body">
                                Užsakymo raktas: <br><a href="{{ route('reservation.show',['order' => $order->key]) }}" class="card-title">{{ $order->key }}</a><br>
                                Kelionė: <br><a href="{{ route('offer', ['category'=>$order->offer->category->slug, 'offer' => $order->offer->id]) }}" class="card-text">{{ $order->offer->name }}</a><br>
                                Įvertinkite pasiūlymą: <br>
                                <app-ratings @if($order->offer->rating) :userrating="{{ $order->offer->rating }}" @endif  :offer="{{ $order->offer->id }}"></app-ratings>
                            </div>
                        </div>
                    @endforeach
               </div>
            </div>
        </div>
    </div>
@endsection
