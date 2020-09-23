@extends('layouts.admin.adminLayout')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-6 offset-3 mt-4">
            <form method="GET" action="{{ route('superAdminOrderFiltered') }}">
                <div class="form-group row">
                    <label for="key" class="col-sm-5 col-form-label">Užsakymo raktas</label>
                    <div class="col-sm-7">
                    <input type="text" name="key" class="form-control" id="key" placeholder="Raktas">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="email" class="col-sm-5 col-form-label">Užsakovo el. paštas</label>
                    <div class="col-sm-7">
                    <input type="text" name="email" class="form-control" id="email" placeholder="El paštas">
                    </div>
                </div>
                <div class="form-group row">
                    <input type="submit" class="btn btn-primary" value="Ieškoti">
                </div>
            </form>
        </div>
        <div class="col-12">
            <table class="table table-dark mt-3">
                <thead>
                    <tr>
                        <th scope="col">Užsakymo raktas</th>
                        <th scope="col">Užsakymo būsena</th>
                        <th scope="col">Užsakovo el. paštas</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($orders as $order)
                <tr>
                    <td>
                        <a href="{{route('superAdminOrder', $order->id)}}">{{ $order->key }}</a>
                    </td>
                    <td class="@if($order->status == 0) bg-warning @elseif($order->status == 1) bg-danger @elseif($order->status == 2) bg-primary @else  bg-success @endif">
                        @if($order->status == 0)
                            Inicijuotas
                        @elseif($order->status == 1)
                            Atšauktas
                        @elseif($order->status == 2)
                            Apmokėtas
                        @else
                            Įvykęs
                        @endif
                    </td>
                    <td>
                        {{ $order->email }}
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
            <div class="pagination_wrapper">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</div>

@endsection