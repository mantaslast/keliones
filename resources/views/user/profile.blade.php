@extends('layouts.app')

@section('content')
    <user-profile :userid="{{ $user->id }}" :profileid="{{ $user->profile->id }}"></user-profile>
@endsection
