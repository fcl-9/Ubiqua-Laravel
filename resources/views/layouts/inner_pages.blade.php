@extends('layouts.app')
@section('css')
    <style>
        .container-head{
            padding-top:0;
            padding-left:0;
            padding-right:0;
            padding-bottom:0;
            margin:0;

            height:60px;
            position:relative;
        }
        .navbar{
            margin-bottom:0;
        }

        .font-header{
            position:absolute;
            color: white;
            text-decoration: none;
            font-weight: bold;
            font-size: 25px;
            bottom: 25px;
            top:12px;
            left:75px;
        }
        .container-head img{
            position: absolute;
            top:9px;
            left: 20px;
        }
    </style>
    @yield('inner-css')
@endsection

@section('content')
    @yield('inner-content')
@endsection
