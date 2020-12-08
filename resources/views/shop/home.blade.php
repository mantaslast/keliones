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

<div class="container">
    <div class="row justify-content-center">
        <div class="col-6">
            <div class="container-title">TOP Šalys</div>
        </div>
        <div class="col-12">
            <div class="top_cities">
                <div class="top_cities_wrapper">
                    <a href="/paieska?country=Turkija" class="top_city big">
                        <div style="background-image:url('data:image/jpeg;base64,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');" class="top_city_image"></div>
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
                        <div style="background-image: url('https://www.guliveriokeliones.lt/files/2016-02/5990_large.jpg');" class="top_city_image"></div>
                        <div class="info">
                            <div class="info_title">
                                Bulgarija 
                            </div>
                            <div class="info_content">
                                
                            </div>
                        </div>
                    </a>
                    <a href="/paieska?country=Andora" class="top_city small">
                        <div style="background-image: url('https://s1.15min.lt/images/photos/2018/09/07/original/andora-5b925f62a13e8.jpg');" class="top_city_image"></div>
                        <div class="info">
                            <div class="info_title">
                                Andora 
                            </div>
                            <div class="info_content">
                            </div>
                        </div>
                    </a>
                    <a href="/paieska?country=Kipras" class="top_city small">
                        <div style="background-image: url('https://g3.dcdn.lt/images/pix/880x550/1kLiiFk6Nns/kipras-80081013.jpg');" class="top_city_image"></div>
                        <div class="info">
                            <div class="info_title">
                                Kipras 
                            </div>
                            <div class="info_content">
                            </div>
                        </div>
                    </a>
                    <a href="/paieska?country=Latvija" class="top_city small">
                        <div style="background-image: url('https://g1.dcdn.lt/images/pix/880x550/45kEeT9xnH4/ryga-72680052.jpg');" class="top_city_image"></div>
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
