@extends('layouts.inner_pages')

@section('inner-css')
    <style>
        .container-head{
            background-color: #f7bc3a;
        }
        .column-text-size{
            display:block;
            text-align: center;
            font-weight: bold;
            font-size: 20px;
        }

        .stock-list{
            width: 100%;
        }
        .row{
            margin: 0;
            height: calc(100% - 71px);
        }
        .col-md-4{
            height:100%;
        }
    </style>
@endsection


@section('inner-content')
    <div class="container-head">
        <img width="40" height="40" src="/img/g3.png">
        <span class="font-header"> Stock </span>
    </div>
    <div style="width:100%; margin-top:20px;"></div>
    <div class="row">
        <div class="col-md-4">
            <span class="column-text-size" > Stock Baixo </span>
            <div class="stock-list" id="low-stock"></div>
        </div>
        <div class="col-md-4" style="border-left: solid thin gray; border-right: solid thin gray;">
            <span class="column-text-size" > Stock Médio </span>
            <div class="stock-list" id="medium-stock"></div>
        </div>
        <div class="col-md-4">
            <span class="column-text-size" > Stock Alto</span>
            <div class="stock-list" id="high-stock"></div>
        </div>
    </div>

@endsection
