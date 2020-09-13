@extends('layouts.admin.adminLayout')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="title text-center">Keisti kategoriją</div>
            <form method="POST" action="{{ action('WEB\admin\categories\CategoriesController@update', ['category'=>$category->id ]) }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            {{ method_field('PUT') }}
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="email">Pavadinimas</label>
                        <input name="name" class="form-control" id="email" value="{{ $category->name ? $category->name : ''}}">
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