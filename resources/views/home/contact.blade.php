@extends('home.layout.master')
@section('content')
    <div class="heading-banner-area overlay-bg">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading-banner">
                        <div class="heading-banner-title">
                            <h2></h2>
                        </div>
                        <div class="breadcumbs pb-15">
                            <ul>
                                <li><a href="/">Home</a></li>
                                <li>Contact</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="contact-us-area  pt-80 pb-80">
        <div class="container">
            <div class="contact-us customer-login bg-white">
                <div class="row">
                    <div class="col-lg-4 col-md-5">
                        <div class="contact-details">
                            <h4 class="title-1 title-border text-uppercase mb-30">contact details</h4>
                            <ul>
                                <li>
                                    <i class="zmdi zmdi-pin"></i>
                                    <span>Taman Juanda P2 no9, i</span>
                                    <span>Durenjaya, Bekasi Timur, Kota Bekas</span>
                                </li>
                                <li>
                                    <i class="zmdi zmdi-phone"></i>
                                    <span>089670214383</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-7 mt-xs-30">
                        <div class="map-area">
                           <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.1488829531963!2d107.02096817466949!3d-6.2441017937442576!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e698e8e65e63f01%3A0xc99002f1907210f4!2sJl.%20Taman%20Juanda%20Blok%20P2%20No.9%2C%20RT.012%2FRW.004%2C%20Duren%20Jaya%2C%20Kec.%20Bekasi%20Tim.%2C%20Kota%20Bks%2C%20Jawa%20Barat%2017111!5e0!3m2!1sid!2sid!4v1750229157367!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
