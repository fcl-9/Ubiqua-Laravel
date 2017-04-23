@extends('layouts.inner_pages')


@section('inner-css')
    <link href="{{ asset('css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/selectize.bootstrap3.css') }}" rel="stylesheet">
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
            <div style="margin-top:20px;"></div>
            <table id="shopping_list">
                <thead>
                    <th>Name</th>
                    <th>Available Weight</th>
                    <th>Action</th>
                </thead>
                <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->actual_weight}}</td>
                        <td><a href="#"><i class="fa fa-trash-o" style="color:#ed9c9b; font-size: 18px;" aria-hidden="true"></i></a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-md-6">
            <span class="font-shop-list">Add New Products</span>
            <div style="margin-top:25px;"></div>
            <form class="form-horizontal">
                <div class="form-group">
                    <label for="inputName" class="col-sm-12 control-label" style="text-align: left;">Product Name: </label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" id="inputProductName" placeholder="Product Name">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-default">Add new product</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


@endsection

@section('scripts')
<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/js/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('/js/selectize.js') }}"></script>

<script>
    $(document).ready(function() {
        $('#shopping_list').DataTable();
    } );
</script>
<script>
    $('#inputProductName').selectize({
        valueField: 'url',
        labelField: 'name',
        searchField: 'name',
        create: false,
        render: {
            option: function(item, escape) {
                return '<div>' +
                    '<span class="title">' +
                    '<span class="name"><i class="icon ' + (item.fork ? 'fork' : 'source') + '"></i>' + escape(item.name) + '</span>' +
                    '<span class="by">' + escape(item.username) + '</span>' +
                    '</span>' +
                    '<span class="description">' + escape(item.description) + '</span>' +
                    '<ul class="meta">' +
                    (item.language ? '<li class="language">' + escape(item.language) + '</li>' : '') +
                    '<li class="watchers"><span>' + escape(item.watchers) + '</span> watchers</li>' +
                    '<li class="forks"><span>' + escape(item.forks) + '</span> forks</li>' +
                    '</ul>' +
                    '</div>';
            }
        },
        score: function(search) {
            var score = this.getScoreFunction(search);
            return function(item) {
                return score(item) * (1 + Math.min(item.watchers / 100, 1));
            };
        },

        load: function(query, callback) {
            if (!query.length) return callback();
            $.ajax({
                url: 'http://localhost:8000/api/product/name/?state=TOBUY',
                type: 'GET',
                error: function() {
                    callback();
                },
                success: function(res) {
                        console.log(res);
                    callback(res.response.slice(0, 10));
                }
            });
        }
    });
</script>

@endsection

