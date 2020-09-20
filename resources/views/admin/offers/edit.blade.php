@extends('layouts.admin.adminLayout')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="title text-center">Keičiamas id-{{ $offer->id }} ({{ $offer->name }}) Pasiūlymas</div>
            <form enctype="multipart/form-data" method="POST" action="{{ action('WEB\admin\offers\OffersController@update',['offer' => $offer->id]) }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            {{ method_field('PUT') }}
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="name">Pavadinimas</label>
                        <input name="name" class="form-control" id="name" value="{{ old('name') ? old('name') : $offer->name }}">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="price">Kaina (&euro;)</label>
                        <input step="0.01" type="number" name="price" class="form-control" id="price" value="{{ old('price') ? old('price') : $offer->price }}">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="discount">Nuolaida (&euro;)</label>
                        <input step="0.01" type="number" name="discount" class="form-control" id="discount" value="{{ old('discount') ? old('discount') : $offer->discount }}">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="country">Šalis</label>
                        <input name="country" class="form-control" id="country" value="{{ old('country') ? old('country') : $offer->country }}">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="city">Miestas</label>
                        <input name="city" class="form-control" id="city" value="{{ old('city') ? old('city') : $offer->city }}">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="naleave_atme">Išvykimo data</label>
                        <input type="date" name="leave_at" class="form-control" id="leave_at" value="{{ old('leave_at') ? old('leave_at') : $offer->leave_at }}">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="arrive_at">Atvykimo data</label>
                        <input type="date" name="arrive_at" class="form-control" id="arrive_at" value="{{ old('arrive_at') ? old('arrive_at') : $offer->arrive_at }}">
                    </div>
                </div>
                <div class="form-row">
                <label for="category">Kategorija</label>
                    <select value="{{ old('category_id') ? old('category_id') : $offer->category_id }}" name="category_id" class="form-control" id="category">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>                        
                        @endforeach
                    </select>
                </div>
                <div class="my-3">
                    <label for="description">Aprašymas</label>
                    <textarea name="description" id="description" cols="30" rows="10">{{ old('description') ? old('description') : $offer->description}}</textarea>
                </div>
                <app-images :imgs="{{ $offer->images }}"></app-images>
                @if($offer->images)
                    @foreach(json_decode($offer->images) as $image)
                        <input type="hidden" value="{{ $image }}" name="imgs[]">
                    @endforeach
                @endif
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