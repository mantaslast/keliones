@extends('layouts.shop.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-6">
            <div class="success_wrapper text-center">
            <span class="success_message my-4">{{$message}}</span>
            <div class="check_mark">
                <div class="sa-icon sa-success animate">
                    <span class="sa-line sa-tip animateSuccessTip"></span>
                    <span class="sa-line sa-long animateSuccessLong"></span>
                    <div class="sa-placeholder"></div>
                    <div class="sa-fix"></div>
                </div>
            </div>
                @if(Session::has('order'))
                <div class="d-flex justify-content-center">
                    Rezervacijos raktas: <span class="success_order_key">{{ Session::get('order')['key']}}</span>
                </div>
                <div class="d-flex justify-content-center">
                    <a href="{{ route('reservation.show', Session::get('order')['key']) }}">Galite atlikti mokėjimą paspaudę čia</a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
