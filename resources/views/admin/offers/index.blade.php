@extends('layouts.admin.adminLayout')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <table class="table table-dark">
                <thead>
                    <tr>
                    <th scope="col">Pavadinimas</th>
                    <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($offers as $offer)
                <tr>
                    <td><a href="{{route('offers.show', $offer->id)}}">{{ $offer->name }}</a></td>
                    <td>
                        <a href="{{route('offers.edit', $offer->id)}}" type="button" class="btn btn-warning">Keisti</a>
                        <form class="d-inline-block" method="POST" action="{{ action('WEB\admin\offers\OffersController@destroy', ['offer' => $offer->id]) }}">
                            {{ method_field('DELETE') }}
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input  class="btn btn-danger deleteBtn" type="button" value="Ištrinti">
                        </form>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection