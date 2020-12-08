@extends('layouts.shop.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-6">
                <div class="container-title">{{ $category->name }}</div>
            </div>
            <div class="col-12">
                <div class="top_deals">
                    @foreach($category->offers as $offer)
                        <div class="top_deal">
                        @if(Auth::user())
                            @if(Auth::user()->isAdmin() || Auth::user()->isSuperAdmin())
                                <a style="position:absolute; right: 0;" href="{{route('offers.edit', $offer->id)}}"><i class="fas fa-edit"></i></a>
                            @endif
                        @endif
                            <a class="top_deal_inner" href="/pasiulymas/{{ $offer->id }}">
                                <div class="discount_badge">{{ round($offer->discount * 100 / $offer->price, 0)}}%</div>
                                <div class="top_deal_image" style="background-image:url('/files/{{ json_decode($offer->images)[0] }}')"></div>
                                <div class="top_deal_info px-3">
                                    <span class="location">{{$offer->city}} <span class="country mx-2">({{ $offer->country }})</span></span>
                                    <div class="top_deal_icons">
                                        @for($i = 0; $i < $offer->countRatings(); $i++)
                                            <i class="fas fa-star"></i>                                   
                                        @endfor
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
