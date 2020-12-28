@extends('layouts.admin.adminLayout')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="title text-center font-weight-bold">Pasiūlymo informacija</div>
            <table class="table table-striped table-dark">
                <thead>
                    <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Pavadinimas</th>
                    <th scope="col">Šalis</th>
                    <th scope="col">Miestas</th>
                    <th scope="col">Kaina (&euro;)</th>
                    <th scope="col">Išvykimo data</th>
                    <th scope="col">Atvykimo data</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <th scope="row">{{$offer->id}}</th>
                    <td>{{ $offer->name }}</td>
                    <td>{{ $offer->country }}</td>
                    <td>{{ $offer->city }}</td>
                    <td>{{ $offer->price }}</td>
                    <td>{{ $offer->leave_at }}</td>
                    <td>{{ $offer->arrive_at }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="offer_gallery">
            @if(json_decode($offer->images))
                @foreach(json_decode($offer->images) as $image)
                    <img class="offer_gallery_image mx-2" src="/files/{{$image}}"/>
                @endforeach
            @endif
        </div>
    </div>
</div>

@endsection