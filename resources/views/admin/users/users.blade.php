@extends('layouts.admin.adminLayout')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-12">
        <table class="table table-dark">
            <thead>
                <tr>
                <th scope="col">Vardas</th>
                <th scope="col">El paštas</th>
                <th scope="col">Rolė</th>
                <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
            @foreach ($users as $user)
            <tr>
                <td><a href="{{route('superAdminUser', $user->id)}}">{{ $user->name }}</a></td>
                <td>{{ $user->email }}</td>
                <td>@if ($user->role == 2) Admin @elseif ($user->role == 3)SuperAdmin @else Klientas @endif</td>
                <td>
                    <a href="{{route('superAdminUserEditForm', $user->id)}}" type="button" class="btn btn-warning">Keisti</a>
                    <form class="d-inline-block" method="POST" action="{{ action('WEB\superAdmin\users\UserController@destroy', ['user' => $user->id]) }}">
                        {{ method_field('DELETE') }}
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input  class="btn btn-danger deleteUser" type="button" value="Ištrinti">
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