@extends('layouts.shop.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="image_wrapper big">
            <div class="image_intro_big"></div>
            <div class="image_intro_content">
                <app-search></app-search>
            </div>
        </div>    
    </div>
</div> 
<div class="container">
    <div class="row justify-content-center">
        <div class="col-6">
            <div class="container-title">TOP Pasiūlymai</div>
        </div>
        <div class="col-12">
            <div class="top_deals">
                @foreach($offers as $offer)
                    <div class="top_deal">
                        @if(Auth::user())
                            @if(Auth::user()->isAdmin() || Auth::user()->isSuperAdmin())
                                <a style="position:absolute; right: 0;" href="{{route('offers.edit', $offer->id)}}"><i class="fas fa-edit"></i></a>
                            @endif
                        @endif
                        <a class="top_deal_inner" href="{{ route('offer', ['category'=>$offer->category->slug,'offer' => $offer->id]) }}">
                            <div class="discount_badge">{{ round($offer->discount * 100 / $offer->price, 0)}}%</div>
                            <div class="top_deal_image lazy" data-srcset="url('/files/{{ json_decode($offer->images)[0] }}')" style="background-image:url('images/web/preloader.gif')"></div>
                            <div class="top_deal_info px-3">
                                <span class="location">{{$offer->city}} <span class="country mx-2">({{ $offer->country }})</span></span>
                                <div class="top_deal_icons">
                                    <i class="far fa-clock"></i>
                                    <i class="fas fa-socks"></i>
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-6">
            <div class="container-title">TOP Šalys</div>
        </div>
        <div class="col-12">
            <div class="top_cities">
                <div class="top_cities_wrapper">
                    <a href="/paieska?country=Turkija" class="top_city big">
                        <div class="top_city_image"></div>
                        <div class="info">
                            <div class="info_title">
                                Turkija
                            </div>
                            <div class="info_content">
                                
                            </div>  
                        </div>
                    </a>
                </div>
                <div class="top_cities_wrapper justify-content-between mt-2 mt-md-0">
                    <a href="/paieska?country=Bulgarija" class="top_city small">
                        <div class="top_city_image"></div>
                        <div class="info">
                            <div class="info_title">
                                Bulgarija 
                            </div>
                            <div class="info_content">
                                
                            </div>
                        </div>
                    </a>
                    <a href="/paieska?country=Andora" class="top_city small">
                        <div class="top_city_image"></div>
                        <div class="info">
                            <div class="info_title">
                                Andora 
                            </div>
                            <div class="info_content">
                            </div>
                        </div>
                    </a>
                    <a href="/paieska?country=Kipras" class="top_city small">
                        <div class="top_city_image"></div>
                        <div class="info">
                            <div class="info_title">
                                Kipras 
                            </div>
                            <div class="info_content">
                            </div>
                        </div>
                    </a>
                    <a href="/paieska?country=Latvija" class="top_city small">
                        <div class="top_city_image"></div>
                        <div class="info">
                            <div class="info_title">
                                Latvija 
                            </div>
                            <div class="info_content">
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-6">
            <div class="container-title">Galima užsisakyti dabar</div>
        </div>
        <div class="col-12">
        <div class="top_deals">
                <div class="top_deal big">
                    <div class="discount_badge">- 50%</div>
                    <div class="top_deal_image"></div>
                    <div class="top_deal_info px-3 additional">
                        <div class="additional_wrapper">
                            <div class="additional_info">
                                <a href="#" class="location">Rio de Jeneiro</a>
                                <div class="additional_info_item">
                                    <span class="additional_info_label">City:</span>illunois,united states
                                </div>
                                <div class="additional_info_item">
                                    <span class="additional_info_label">Rating:</span>1 2 3 4 5
                                </div>
                            </div>
                            <div class="additional_price">
                                420 &euro;
                            </div>
                        </div>
                    </div>
                </div>
                <div class="top_deal big">
                    <div class="top_deal_image"></div>
                    <div class="top_deal_info px-3 additional">
                        <div class="additional_wrapper">
                            <div class="additional_info">
                                <a href="#" class="location">Rio de Jeneiro</a>
                                <div class="additional_info_item">
                                    <span class="additional_info_label">City:</span>illunois,united states
                                </div>
                                <div class="additional_info_item">
                                    <span class="additional_info_label">Rating:</span>1 2 3 4 5
                                </div>
                            </div>
                            <div class="additional_price">
                                540 &euro;
                            </div>
                        </div>
                    </div>
                </div>
                <div class="top_deal big">
                    <div class="top_deal_image"></div>
                    <div class="top_deal_info px-3 additional">
                        <div class="additional_wrapper">
                            <div class="additional_info">
                            <a href="#" class="location">Rio de Jeneiro</a>
                                <div class="additional_info_item">
                                    <span class="additional_info_label">City:</span>illunois,united states
                                </div>
                                <div class="additional_info_item">
                                    <span class="additional_info_label">Rating:</span>1 2 3 4 5
                                </div>
                            </div>
                            <div class="additional_price">
                                380 &euro;
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> -->
@endsection
