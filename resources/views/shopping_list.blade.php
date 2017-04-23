@extends('layouts.inner_pages')


@section('inner-css')
<style>
    #app{
        height: 100%;
    }
    .container-head{
        background-color: #ed9c9b;
    }
    .row{
        margin:0;
        height:calc(100% - 132px);
    }
    .col-md-6{
        height: 100%;
    }
    .font-shop-list{
        font-weight: bold;
        font-size: 20px;
        display:block;
        text-align: center;
    }
</style>
@endsection

@section('inner-content')
    <div class="container-head">
        <img width="40" height="40" src="/img/g4.png">
        <span class="font-header"> To Buy </span>
    </div>
    <div style="margin-top: 20px;"></div>
    <div class="row">
        <div class="col-md-6">
            <span class="font-shop-list">Shopping List</span>
        </div>
        <div class="col-md-6">
            <span class="font-shop-list">Add New Products</span>
        </div>
    </div>
@endsection

