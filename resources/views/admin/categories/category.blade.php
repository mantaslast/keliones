@extends('layouts.admin.adminLayout')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
        <div class="title text-center font-weight-bold">Kategorijos informacija</div>
            <table class="table table-striped table-dark">
                <thead>
                    <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Pavadinimas</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <th scope="row">{{$category->id}}</th>
                    <td>{{ $category->name }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection