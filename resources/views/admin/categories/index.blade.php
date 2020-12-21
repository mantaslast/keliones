@extends('layouts.admin.adminLayout')
@section('content')
<div class="container">
    <div class="row">
    <div class="title ml-3">Kategorijos</div>
        <div class="col-12">
            <app-categories-table :categories="{{json_encode($categories)}}"></app-categories-table>
        </div>
    </div>
</div>

@endsection