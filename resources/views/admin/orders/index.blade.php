@extends('layouts.admin.adminLayout')
@section('content')
<div class="container">
    <div class="row">
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
                        {{ $order->getStatus() }}
                    </td>
                    <td>
                        {{ $order->email }}
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection