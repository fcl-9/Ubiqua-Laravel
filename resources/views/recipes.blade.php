@extends('layouts.inner_pages')


@section('inner-css')
    <style>
        .container-head{
            background-color: #b2d233;
            margin-bottom: 15px;
        }
        .col-md-4, .col-md-8{
            float:none;
            display:inline-block;
            vertical-align:middle;
            margin-right:-4px;
        }
    </style>
@endsection

@section('inner-content')
    <div class="container-head">
        <img width="40" height="40" src="/img/g2.png">
        <span class="font-header"> Recipes </span>
    </div>
    <div class="container-fluid">
        @foreach($recipes as $recipe)
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title">{{$recipe["title"]}}</h3>
                </div>
                <div class="panel-body">
                    <div class="col-md-4">
                        <img class="img-responsive center-block" src="{{ $recipe["image"] }}">
                    </div>
                    <div class="col-md-8">
                        <p>Available Ingredients:</p>
                        <ul>
                            @foreach($recipe["usedIngredients"] as $ingredient)
                                <li> {{ $ingredient->name }}</li>
                            @endforeach
                        </ul>
                        @if ($recipe["missedIngredientCount"] > 0)
                            <p class="text-danger">There are {{ $recipe["missedIngredientCount"] }} missing ingredients:</p>
                            <ul>
                                @foreach($recipe["missedIngredients"] as $ingredient)
                                    <li> {{ $ingredient->name }}</li>
                                @endforeach
                            </ul>
                        @endif
                        <button type="button" class="btn btn-circle btn-lg" data-toggle="modal" data-target="#recipe{{ $recipe["id"] }}"><i class="glyphicon glyphicon-plus"></i></button>
                    </div>
                </div>
            </div>
            <div id="recipe{{ $recipe["id"] }}" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">{{ $recipe["title"] }}</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                            <div class="col-md-4">
                                <img class="img-responsive center-block" src="{{ $recipe["image"] }}">
                            </div>
                                <div class="col-md-8">
                                    <p>Steps:</p>
                                        @foreach($recipe["steps"] as $step)
                                            <p> {{ $step->step }}</p>
                                        @endforeach
                                </div>
                            </div>
                            <div class="col-md-4">
                                <p>Available Ingredients:</p>
                                <ul>
                                    @foreach($recipe["usedIngredients"] as $ingredient)
                                        <li> {{ $ingredient->name }}</li>
                                    @endforeach
                                </ul>
                                @if ($recipe["missedIngredientCount"] > 0)
                                    <p class="text-danger">There are {{ $recipe["missedIngredientCount"] }} missing ingredients:</p>
                                    <ul>
                                        @foreach($recipe["missedIngredients"] as $ingredient)
                                            <li> {{ $ingredient->name }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="form-group">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection