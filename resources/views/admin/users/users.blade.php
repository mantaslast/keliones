@extends('layouts.admin.adminLayout')
@section('content')

<div class="container">
    <div class="row">
    <div class="title ml-3">Vartotojai</div>
        <div class="col-12">
            <app-users-table :users="{{json_encode($users)}}"></app-users-table>
        </div>
    </div>
</div>

@endsection