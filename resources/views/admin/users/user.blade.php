@extends('layouts.admin.adminLayout')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="title text-center font-weight-bold">Vartotojo paskyros informacija</div>
            <table class="table table-striped table-dark">
                <thead>
                    <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Vardas</th>
                    <th scope="col">El. paštas</th>
                    <th scope="col">Rolė</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <th scope="row">{{$user->id}}</th>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>
                    </tr>
                </tbody>
            </table>
            
            <div class="title text-center font-weight-bold">Profilis</div>
            <table class="table table-striped table-dark">
                <thead>
                    <tr>
                    <th scope="col">Telefonas</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <td>{{ $user->phone ?? ' '}}</td>
                    </tr>
                </tbody>
            </table>
            
            <div class="title text-center font-weight-bold">Užsakymai</div>
        </div>
    </div>
</div>

@endsection