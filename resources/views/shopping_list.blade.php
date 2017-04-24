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
        .btn-circle.btn-lg {
            position: fixed;
            bottom:20px;
            right: 20px;
            width: 50px;
            height: 50px;
            padding: 10px 16px;
            font-size: 18px;
            line-height: 1.33;
            border-radius: 25px;
            background-color: #ed9c9b;
            color:white;
        }
    </style>
@endsection

@section('inner-content')
    <div class="container-head">
        <img width="40" height="40" src="/img/g4.png">
        <span class="font-header"> To Buy </span>
    </div>
    <div id="alert"></div>
    <div style="margin-top: 20px;"></div>
    <div class="row">
        <div class="col-md-12">
            <span class="font-shop-list">Shopping List</span>
            <div style="margin-top:20px;"></div>
            <table class="table table-striped" id="shopping_list">
                <thead>
                <th>Name</th>
                <th>Available Weight</th>
                <th>Action</th>
                </thead>
                <tbody>
                   @foreach($products as $product)

                    <tr>
                        <td>{{ $product["name"] }}</td>
                        <td>{{ $product["quantity"]}}</td>
                        <td>
                            <i class="fa fa-trash-o" style="color:#ed9c9b; font-size: 18px;" aria-hidden="true"></i>
                            <input type="hidden" value="{{$product['id']}}">
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <button type="button" class="btn btn-circle btn-lg" data-toggle="modal" data-target="#addnewproduct"><i class="glyphicon glyphicon-plus"></i></button>
            <!-- data-toggle="modal" data-target="#addnewproduct"-->
        </div>
        <div id="addnewproduct" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Add new product</h4>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal">
                            <div class="form-group">
                                <label for="inputName" class="col-sm-12 control-label" style="text-align: left;">Product Name: </label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="inputProductName" placeholder="Product Name">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <div class="form-group">
                            <button type="submit" class="btn btn-default" id="add_to_list" data-dismiss="modal">Add new product</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>

                </div>
            </div>
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

                    var select = $('#inputProductName').selectize({
                            valueField: 'id',
                            labelField: 'name',
                            searchField: 'name',
                            create: false,
                            persist:true,
                            render: {
                                option: function (item, escape) {
                                    console.log(item);
                                    return '<div>' +
                                            '<span class="title">' +
                                            '   <span class="name">'+ escape(item.name) + '</span>' +
                                            '</span>' +
                                            '</div>';
                                }
                            },
                            load: function (query, callback) {
                                if (!query.length) return callback();
                                $.ajax({
                                    url: 'http://localhost:8000/api/product/name/?state=NOTOBUY&?querystring=' + encodeURIComponent(query),
                                    type: 'GET',
                                    error: function () {
                                        callback();
                                    },
                                    success: function (res) {
                                        //console.log("Ajax Request");
                                        callback(res.response.slice(0, 10));
                                    }
                                });
                            }
                        });

                    $('#add_to_list').click(function() {
                        var data = {"state": "TOBUY"};
                        var items = $('.selectize-input').children(".item");
                        for (var i = 0; i < items.length; i++) {
                            console.log(items[i].outerText);
                            url="http://localhost:8000/api/product/"+items[i].getAttribute("data-value")+"/state";
                            $.ajax({
                                type: "POST",
                                url: url,
                                data: data,
                                success: success,
                                error: error
                            });
                            select[0].selectize.removeItem(items[i].getAttribute("data-value"));
                        }

                        function error (e){
                            $("#alert").addClass("alert alert-danger").attr("role","alert").html("<b>Oh snap!</b> Some problem occured adding the product to the To Buy List");
                        }

                        function success(){
                            $("#alert").addClass("alert alert-success").attr("role","alert").html("New items were added to your shopping list!");

                            var selectize = select[0].selectize;
                            selectize.clearOptions();
                            selectize.renderCache = {};
                        }
                    });
                    $('.fa-trash-o').click(function () {
                        var selected = $(this);
                        var id_product = selected.next().val();
                        $.post("/api/product/" + id_product + "/state", {"state": "DISABLE"} ,function() {
                            $("#alert").addClass("alert alert-success").attr("role","alert").html("The product was removed from your To Buy list!");

                        }).fail(function(err) {
                            console.log(err);
                            $("#alert").addClass("alert alert-danger").attr("role","alert").html("<b>Oh snap!</b> Some problem occured removing the product from the To Buy List");
                        });
                    });
                });
            </script>


@endsection

