@extends('layouts.app')
@section('content')
<nav class="navbar navbar-expand-lg navbar-light fixed-top" 
style="background:rgba(0, 100, 20, 0.4)">
    <div class="container">
        <a class="navbar-brand" href="#">
            <img src="{{asset('storage/images/logo4.png')}}">
        </a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto my-2 my-lg-0">
            <li class="nav-item">
                <a class="btn btn-primary ml-2 btn-sm" href="/home" role="button">Home</a>
            </li>
            <li class="nav-item">
                <a class="btn btn-primary ml-2 btn-sm" href="/about" role="button">About Us</a>
            </li>
            <li class="nav-item">
                <a class="btn btn-primary ml-2 btn-sm" href="/library" role="button">Library</a>
            </li>
            <li class="nav-item">
                <a class="btn btn-primary ml-2 btn-sm" href="http://192.168.1.31:8080" target="_blank" role="button">Bursary</a>
            </li>
            <li class="nav-item">
                <a class="btn btn-primary ml-2 btn-sm" href="http://192.168.1.84/mcchstcbt/admin" target="_blank" role="button">Examination</a>
            </li>
        </ul>
        </div>
    </div>
</nav>

{{-- <div class="w-100 h-100"> --}}
{{-- <nav class="navbar navbar-expand-sm navbar-dark text-white bg-primary">
    <a class="navbar-brand" href="#">
        <img src="{{asset('storage/images/logo3.png')}}">
    </a>
    <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId"
        aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavId">
        <ul class="navbar-nav" style="margin-left: 400px;">
            <li class="nav-item">
                <a href="/" class="nav-link">Home</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">About Us</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/library">Library<span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" blank href="http://192.168.1.31:8080" target="_blank">Bursary</a>
            </li>
            
            <li class="nav-item">
                <a href="#" class="nav-link">Examination</a>
            </li>
        </ul>
    </div>
</nav> --}}
{{-- <div class="container shadow w-100">
    <nav class="nav justify-content-center" id="logoNav">
        <a class="navbar-brand" href="#">
            <img src="assets/img/logobig.png" alt="" style="width: 200px; height:120px;">
        </a>
    </nav>
</div> --}}
{{-- <div class="shadow w-100" style="position:absolute;">
    <nav class="nav text-white py-2">
        <a class="nav-link float-right" href="music">Music</a>
        <a class="nav-link float-right" href="videos">Videos</a>
        <a class="nav-link float-right" href="entertainment">Entertainment</a>
    </nav>
</div> --}}
<div>
    <div id="carouselId" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselId" data-slide-to="0" class="active"></li>
            <li data-target="#carouselId" data-slide-to="1"></li>
            <li data-target="#carouselId" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner" role="listbox">
            <div class="carousel-item active">
                <img src="{{asset('storage/images/img4.jpg')}}" class="w-100">
            </div>
            <div class="carousel-item">
                <img src="{{asset('storage/images/img5.jpg')}}" class="w-100">
            </div>
            <div class="carousel-item">
                <img src="{{asset('storage/images/img6.jpg')}}" class="w-100">
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselId" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselId" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</div>

@endsection
