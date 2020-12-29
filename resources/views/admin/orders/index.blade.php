@extends('layouts.admin.adminLayout')
@section('content')
<div class="container">
    <div class="row">
        <div class="title ml-3">Užsakymai</div>
        <div class="col-12">
            <app-orders-table :orders="{{json_encode($orders)}}"></app-orders-table>
        </div>
    </div>
</div>

@endsection