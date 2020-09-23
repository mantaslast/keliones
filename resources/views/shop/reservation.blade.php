@extends('layouts.shop.app', ['title' => 'Rezervacija'])

@section('content')
<div class="container">
    <div class="row">
        <div class="col-6">
            <form class="my-3" method="POST" action="{{ route('reservation.store') }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="offer" value="{{ $offer->id }}">
                <div class="form-row">
                    <div class="form-group col-md-12">
                    <label for="email">El. paštas</label>
                    <input name="email" type="email" class="form-control" id="email" placeholder="El.paštas" value="{{ Auth::user() ? Auth::user()->email : '' }}">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                    <label for="phone">Telefono numeris</label>
                    <input name="phone" class="form-control" id="phone" placeholder="Telefono numeris" value="{{ Auth::user() ? Auth::user()->phone : '' }}">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Rezervuoti</button>
                @if ($errors->any())
                    <div class="errors my-3">
                        @foreach ($errors->all() as $error)
                            <div class="error">{{$error}}</div>
                        @endforeach
                    </div>
                @endif
            </form>
        </div>
        <div class="col-6">
            <div class="card my-3">
                <div class="card-img-top reservation_deal" style="background-image:url('/files/{{ json_decode($offer->images)[0] }}')"></div>
                <div class="card-body">
                    <h5 class="card-title">{{ $offer->name }}</h5>
                    <p class="card-text">{{ $offer->city }} ({{ $offer->country }}) </p>
                    <span class="currPrice">{{ $offer->price }} &euro;</span>
                    <span class="discount mx-3">{{ $offer->price + $offer->discount }} &euro;</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
