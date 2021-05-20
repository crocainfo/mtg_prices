@extends('base')

@section('content')
    <!-- Masthead-->
    <header class="masthead">
        <div class="container h-100">
            <div class="row h-100 align-items-center justify-content-center text-center">
                <div class="col-lg-10 align-self-end">
                    <h1><img src="{{asset('images/blue_m.png')}}" class="blue_mana"></h1>
                    <h1 class="text-uppercase text-white font-weight-bold">CounterSpell</h1>
                    <hr class="divider my-4" />
                </div>
                <div class="col-lg-8 align-self-baseline">
                    <p class="text-white font-weight-light mb-5">A website where you can search for your desired Magic The Gathering cards at te lowest price in the market.</p>
                    <a class="btn btn-primary btn-xl js-scroll-trigger btn-call-action" href="{{ url('/shop') }}">Start Searching</a>
                </div>
            </div>
        </div>
    </header>

@endsection

@section('customCSS')

    <link href="{{asset('css/app.css')}}" rel="stylesheet" />

@endsection
