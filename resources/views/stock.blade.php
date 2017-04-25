@extends('layouts.inner_pages')

@section('inner-css')
    <link href="{{ asset('css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
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
        <div class="col-md-12">
            <div id="alert"></div>
            <div class="stock-list">
                <div class="table-responsive">
                    <table class="table table-striped" id="stock">
                        <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Available Weight</th>
                            <th>State</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($stocks as $stock)
                            <tr>
                                <td>{{ $stock["name"] }}</td>
                                <td>{{ $stock["quantity"] }}</td>
                                @if($stock["state"] == "ONSTOCK")
                                    <td>On Stock</td>
                                    <td>
                                        <i style="font-size: 18px; color:#f7bc3a;" class="fa fa-cart-plus" aria-hidden="true"></i>
                                        <input type="hidden" value="{{ $stock["id"] }}">
                                    </td>
                                @else
                                    <td class="text-danger">Need To Buy</td>
                                    <td>-</td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/js/dataTables.bootstrap.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#stock').DataTable();
            $('.fa-cart-plus').click(function () {
                var selected = $(this);
                var id_product = selected.next().val();
                $.post("/api/product/" + id_product + "/state", {"state": "TOBUY"} ,function() {
                    $("#alert").addClass("alert alert-success alert-dismissible")
                        .attr("role","alert")
                        .html("The product was added to your To Buy list!")
                        .append('<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>');
                    selected.parent().prev().addClass("text-danger").text("Need To Buy");
                    selected.replaceWith("-");
                }).fail(function(err) {
                    console.log(err);
                    $("#alert").addClass("alert alert-danger alert-dismissible")
                        .attr("role","alert")
                        .html("<b>Oh snap!</b> Some problem occured adding the product to the To Buy List")
                        .append('<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>');
                })
            })
        } );
    </script>
@endsection