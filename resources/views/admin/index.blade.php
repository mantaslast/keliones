@extends('layouts.admin.adminLayout')

@section('content')
<div class="container">
    <!-- Trys korteles -->
    <div class="row">
        <div class="col-sm-4">
            <div class="analytics_card">
                <div class="row">
                    <div class="col-sm-5">
                        <div class="analytics_card_title">
                            Pelnas
                        </div>
                        <div class="analytics_card_content">
                            200
                        </div>
                    </div>
                    <div class="col-sm-7">
                        <i class="fas fa-chart-pie"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="analytics_card">
                <div class="row">
                    <div class="col-sm-5">
                        <div class="analytics_card_title">
                            Užsakymai
                        </div>
                        <div class="analytics_card_content">
                            200
                        </div>
                    </div>
                    <div class="col-sm-7">
                    <i class="far fa-chart-bar"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="analytics_card">
                <div class="row">
                    <div class="col-sm-5">
                        <div class="analytics_card_title">
                            Šiandien
                        </div>
                        <div class="analytics_card_content">
                            200
                        </div>
                    </div>
                    <div class="col-sm-7">
                    <i class="fas fa-chart-area"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Du chartai -->
    <div class="row mt-3">
        <div class="col-sm-6">
            <div class="chartBlock">
                asd
            </div>
        </div>
        <div class="col-sm-6">
            <div class="chartBlock">
                        wqe
            </div>
        </div>
    </div>
    
</div>
@endsection