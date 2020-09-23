@extends('layouts.shop.app')

@section('content')
    <user-profile :userid="{{ $user->id }}"></user-profile>
@endsection
