@extends('layouts.admin.adminLayout')

@section('content')
<app-dashboard :analyticsdata="{{json_encode($data)}}"></app-dashboard>
@endsection