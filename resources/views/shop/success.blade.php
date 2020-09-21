@extends('layouts.shop.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-6">
            <div class="success_wrapper text-center">
            <span class="success_message my-4">{{$message}}</span>
            <img class="my-4" src="/images/web/success.png" alt="">
                @if(Session::has('order'))
                <div class="d-flex justify-content-center">
                Rezervacijos raktas: <span class="success_order_key">{{ Session::get('order')['key']}}</span>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
