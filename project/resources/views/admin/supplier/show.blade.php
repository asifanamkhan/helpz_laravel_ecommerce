@extends('layouts.load')
@section('content')

            <div class="content-area no-padding">
                <div class="add-product-content">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="product-description">
                                <div class="body-area">

                        <div class="table-responsive show-table">
                            <table class="table">
                                <tr>
                                    <th>{{ __("Supplier ID#") }}</th>
                                    <td>{{$data->id}}</td>
                                </tr>
                                <tr>
                                    <th>{{ __("Supplier Name") }}</th>
                                    <td>{{$data->name}}</td>
                                </tr>
                                <tr>
                                    <th>{{ __("Supplier Email") }}</th>
                                    <td>{{$data->email}}</td>
                                </tr>
                                <tr>
                                    <th>{{ __("Supplier Phone") }}</th>
                                    <td>{{$data->phone}}</td>
                                </tr>
                                <tr>
                                    <th>{{ __("Product type") }}</th>
                                    <td>{{$data->product_type}}</td>
                                </tr>
                                <tr>
                                    <th>{{ __("Shop name") }}</th>
                                    <td>{{$data->shop_name}}</td>
                                </tr>
                                <tr>
                                    <th>{{ __("Joined") }}</th>
                                    <td>{{$data->created_at->diffForHumans()}}</td>
                                </tr>
                            </table>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection