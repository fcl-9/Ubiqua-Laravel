@extends('layouts.app')

@section('css')
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
@endsection

@section('content')
    <img class="image" src="img/17902649_1612740275406723_2073634961_o.jpg"/>
    <h2 class="image-caption"> Command your pantry from everywhere.</h2>
    <div class="container">
        <hr>
        <div class="row">
            <div class="col-md-1 text-center">
            </div>
            <div class="col-sm-2 text-center">
                <a href="/shopping_list" class="btn btn-lg btn-default">
                    <img src="img/tobuy.png"/><br/>
                    To-buy <br>
                </a></div>
            <div class="col-sm-2 text-center">
                <a href="/recipes" class="btn btn-lg btn-default">
                    <img src="img/recipes.png"/><br/>
                    Recipes <br>
                </a>
            </div>
            <div class="col-sm-2 text-center">
                <a href="/stock" class="btn btn-lg btn-default">
                    <img src="img/shelf.png"/><br/>
                    Stock <br>
                </a>
            </div>
            <div class="col-sm-2 text-center">
                <a href="/sensors" class="btn btn-lg btn-default">
                    <img src="img/sensors.png"/><br/>
                    Sensors <br>
                </a>
            </div>
            <div class="col-sm-2 text-center">
                <a href="/settings" class="btn btn-lg btn-default">
                    <img src="img/settings.png"/><br/>
                    Settings <br>
                </a>
            </div>
            <div class="col-md-1 text-center">
            </div>
        </div>

    </div>
@endsection
