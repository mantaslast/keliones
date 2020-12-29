@extends('layouts.admin.adminLayout')
@section('content')
<div class="container">
    <div class="row">
    <div class="title ml-3">Pasiūlymai</div>
        <div class="col-12">
            <app-offers-table :offers="{{json_encode($offers)}}"></app-offers-table>
        </div>
    </div>
</div>

@endsection