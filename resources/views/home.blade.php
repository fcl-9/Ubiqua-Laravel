@extends('layouts.app')

@section('css')
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
    <link href="{{asset('css/mainClock.css')}}" rel="stylesheet">
    <style>
        .container{
            padding-top:0;
            padding-left:0;
            padding-right:0;
            padding-bottom:0;
            margin:0;
            width:100%;
            height: 100%;
        }
        .height-adjust{
            height: 50%;
            padding:10px;
        }
        .row{
            margin: 0;
        }
        .button-font{
            position:absolute;
            color: white;
            text-decoration: none;
            font-weight: bold;
            font-size: 16px;
            bottom: 0;
            margin: 0 auto;
            left: 0;
            right: 0;

        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="row" style="height: 100%;">
            <div class="col-md-6 " style="height: 100%; padding-right: 0;">
                <div class="clock-container">
                    <div id="myclock"></div>
                </div>

            </div>
            <div class="col-md-6" style="height: 100%;" style="padding-right: 0">
                <div class="row" style="height: 100%;">
                    <div class="col-md-6 height-adjust">
                        <a class="btn btn-block" style="position: relative; background-color: #ed9c9b;" href="#" role="button"><img src="/img/tobuy.png"><span class="button-font">To Buy</span></a>
                    </div>
                    <div class="col-md-6 height-adjust">
                        <a class="btn btn-block" style="position: relative; background-color: #f7bc3a" href="#" role="button"><span class="button-font">Stock</span></a>
                    </div>
                    <div class="col-md-6 height-adjust">
                        <a class="btn btn-block" style="position: relative; background-color: #c0e6e7" href="#" role="button"><span class="button-font">Sensor</span></a>
                    </div>
                    <div class="col-md-6 height-adjust">
                        <a class="btn btn-block" style="position: relative; background-color: #b2d233" href="#" role="button"><span class="button-font">Recipes</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script language="javascript" type="text/javascript" src="{{ asset('js/jquery.thooClock.js') }}"></script>
    <script language="javascript">
        var intVal, myclock;

        $(window).resize(function(){
            window.location.reload()
        });

        $(document).ready(function(){
            //clock plugin constructor
            $('#myclock').thooClock({
                size:$("#myclock").parent().height()/1.4,
                showNumerals:true
            });
        });
    </script>
    @endsection
