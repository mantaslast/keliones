@extends('layouts.admin.adminLayout')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="title text-center font-weight-bold">Užsakymo informacija</div>
            <table class="table table-striped  table-dark mt-3">
                <thead>
                    <tr>
                    <th scope="col">#raktas</th>
                    <th scope="col">Užsakovo el. paštas</th>
                    <th scope="col">Užsakovo tel. nr.</th>
                    <th scope="col">Būsena</th>
                    <th scope="col">Atnaujintas</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <th scope="row">{{ $order->key }}</th>
                    <td>{{ $order->email ?? '' }}</td>
                    <td>{{ $order->phone ?? '' }}</td>
                    <td class="@if($order->status == 0) bg-warning @elseif($order->status == 1) bg-danger @elseif($order->status == 2) bg-primary @else  bg-success @endif">{{ $order->getStatus() }}</td>
                    <td>{{ $order->updated_at }}</td>
                    </tr>
                </tbody>
            </table>
            <div class="deal_card mt-4">
                <div class="deal_description">
                {{ $order->description }}
                </div>
            </div>
            @if($order->user_id)
                <div class="title text-center font-weight-bold my-4">Vartotojo paskyros informacija</div>
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
                        <th scope="row">{{App\User::find($order->user_id)->id}}</th>
                        <td><a href="{{ route('superAdminUser',['user' => App\User::find($order->user_id)->id]) }}">{{ App\User::find($order->user_id)->name }}</a></td>
                        <td>{{ App\User::find($order->user_id)->email }}</td>
                        <td>{{ App\User::find($order->user_id)->role }}</td>
                        </tr>
                    </tbody>
                </table>
            @endif

            @if (Auth::user()->isSuperAdmin() || Auth::user()->isAdmin())
                <form method="POST" action="{{ action('WEB\superAdmin\orders\OrdersController@update', ['order'=>$order->id ]) }}" >     
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    {{ method_field('PUT') }}    
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="inputState">Keisti užsakymo būseną</label>
                            <select name="status" value="{{ $order->status }}" id="inputState" class="form-control">
                                <option selected>Pasirinkti...</option>
                                <option {{ $order->status == 0 ? 'selected' : '' }} value="0">Inicijuotas</option>
                                <option {{ $order->status == 1 ? 'selected' : '' }} value="1">Atšauktas</option>
                                <option {{ $order->status == 2 ? 'selected' : '' }} value="2">Apmokėtas</option>
                                <option {{ $order->status == 3 ? 'selected' : '' }} value="3">Įvykęs</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-2 ml-0">Išsaugoti</button>
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
            @endif
        </div>
    </div>
</div>

@endsection