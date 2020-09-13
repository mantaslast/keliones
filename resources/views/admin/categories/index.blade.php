@extends('layouts.admin.adminLayout')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <table class="table table-dark">
                <thead>
                    <tr>
                    <th scope="col">Pavadinimas</th>
                    <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($categories as $category)
                <tr>
                    <td><a href="{{route('categories.show', $category->id)}}">{{ $category->name }}</a></td>
                    <td>
                        <a href="{{route('categories.edit', $category->id)}}" type="button" class="btn btn-warning">Keisti</a>
                        <form class="d-inline-block" method="POST" action="{{ action('WEB\admin\categories\CategoriesController@destroy', ['category' => $category->id]) }}">
                            {{ method_field('DELETE') }}
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input  class="btn btn-danger deleteBtn" type="button" value="Ištrinti">
                        </form>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection