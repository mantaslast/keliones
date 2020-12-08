@extends('layouts.shop.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-6">
                <div class="container-title">@if(count($offers) > 0) Paieškos rezultatai @else Pagal Jūsų paieškos kriterijus pasiūlymų neradome... @endif</div>
            </div>
            @if (count($offers) > 0)
            <div class="col-12">
                <div class="top_deals">
                    @foreach($offers as $offer)
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
                                </div>
                            </a>
                        </div>      
                    @endforeach
                </div>
                <div class="pagination_wrapper">
                {{ $offers->links() }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
