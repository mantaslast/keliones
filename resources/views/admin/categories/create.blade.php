@extends('layouts.admin.adminLayout')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="title text-center">Nauja kategorija</div>
            <form method="POST" action="{{ action('WEB\admin\categories\CategoriesController@store') }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="name">Pavadinimas</label>
                        <input name="name" class="form-control" id="name">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="slug">Seo url (Vietoje tarpų brūkšneliai, be lietuviškų simbolių)</label>
                        <input name="slug" class="form-control" id="slug">
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
        </div>
    </div>
</div>

@endsection