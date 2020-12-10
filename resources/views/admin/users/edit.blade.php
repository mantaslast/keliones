@extends('layouts.admin.adminLayout')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="title text-center">Vartotojo <i>({{$user->name}})</i> informacijos keitimas</div>
            <form method="POST" action="{{ action('WEB\superAdmin\users\UserController@update', ['user'=>$user->id ]) }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            {{ method_field('PUT') }}
                <div class="form-row">
                    <div class="form-group col-md-6">
                    <label for="email">El. paštas</label>
                    <input name="email" type="email" class="form-control" id="email" value="{{ $user->email }}">
                    </div>
                    <div class="form-group col-md-6">
                    <label for="name">Vardas</label>
                    <input name="name" type="text" class="form-control" id="name" value="{{ $user->name }}">
                    </div>
                    <div class="form-group col-md-12">
                    <label for="phone">Telefonas</label>
                    <input name="phone" type="text" class="form-control" id="phone" value="{{ $user->phone ? $user->phone : '' }}">
                    </div>
                    <div class="form-group col-md-6">
                    <label for="password">Slaptažodis</label>
                    <input name="password" type="password" class="form-control" id="password">
                    </div>
                    <div class="form-group col-md-6">
                    <label for="repeatPassword">Pakartoti slaptažodį</label>
                    <input name="password_confirmation" type="password" class="form-control" id="repeatPassword">
                    </div>

                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                    <label for="inputAddress">Adresas</label>
                    <input name="address" type="text" class="form-control" id="inputAddress" value="{{ $user->address ? $user->address : '' }}" >
                    </div>
                    <div class="form-group col-md-6">
                    <label for="country">Šalis</label>
                    <input name="country" type="text" class="form-control" id="country" value="{{ $user->country ? $user->country : '' }}" >
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-12">
                        <label class="mr-sm-2" for="role">Rolė</label>
                        <select  @if (Auth::user()->isAdmin()) disabled @endif name="role" class="custom-select" id="role">
                        @for ($i = 0; $i < 4; $i++)
                            @if($i == 0)
                                <option value="{{ $i }}">Pasirinkti...</option>
                            @else
                                <option @if($i == $user->role) selected @endif value="{{$i}}">@if($i == 1) Klientas @elseif($i == 2) Administratorius @elseif($i == 3) Super Administratorius @endif</option>
                            @endif
                        @endfor
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Išsaugoti</button>
            </form>
                @if ($errors->any())
                    <div class="errors my-3">
                        @foreach ($errors->all() as $error)
                            <div class="error">{{$error}}</div>
                        @endforeach
                    </div>
                @endif

                @if(session('success'))
                    <div class="success my-3">
                        <div class="successMsg">{{session('success')}}</div>
                    </div>
                @endif
        </div>
    </div>
</div>

@endsection