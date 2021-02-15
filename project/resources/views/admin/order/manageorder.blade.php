@extends('layouts.admin')

@section('styles')

    <style type="text/css">

        .input-field {
            padding: 15px 20px;
        }

    </style>

@endsection

@section('content')

    <input type="hidden" id="headerdata" value="{{ __('ORDER ') }}">

    <div class="content-area">
        <div class="mr-breadcrumb">
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="heading">{{ __('Order Management') }}</h4>
                    <ul class="links">
                        <li>
                            <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a>
                        </li>
                        <li>
                            <a href="javascript:;">{{ __('Orders') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('admin-order-manage') }}">{{ __('Orders Management') }}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="product-area">
            <div class="row">
                <div class="col-lg-12 ">
                    <div class="mr-table allproduct">
                        <form action="{{route('ordered-product-assignTo-Supplier-filter')}}" method="POST" onSubmit="document.getElementById('submit').disabled=true;">
                            {{csrf_field()}}
                        <div class="row">
                            <div class="col-md-5">
                                <input type="date" class="input-field" name="start_date">
                            </div>
                            <div class="col-md-5">
                                <input type="date" class="input-field" name="end_date">
                            </div>
                            {{--<div class="col-md-4">--}}
                            {{--<select name="" id="" class="input-field">--}}
                            {{--<option value="">Select Category</option>--}}
                            {{--@foreach($categories as $category)--}}
                            {{--<option value="cat,{{$category->id}}">{{$category->name}}</option>--}}
                            {{--@if($category->subs)--}}
                            {{--@foreach($category->subs as $subcategory)--}}
                            {{--<option value="sub,{{$subcategory->id}}">{{$subcategory->name}}</option>--}}
                            {{--@if($subcategory->childs)--}}
                            {{--@foreach($subcategory->childs as $childcategory)--}}
                            {{--<option value="child,{{$childcategory->id}}">{{$childcategory->name}}</option>--}}
                            {{--@endforeach--}}
                            {{--@endif--}}
                            {{--@endforeach--}}
                            {{--@endif--}}
                            {{--@endforeach--}}
                            {{--</select>--}}
                            {{--</div>--}}
                            {{--<div class="col-md-4">--}}
                            {{--<select name="" id="" class="input-field">--}}
                            {{--<option value="">Select Product</option>--}}
                            {{--@foreach($porducts as $porduct)--}}
                            {{--<option value="pro,{{$porduct->id}}">{{$porduct->name}}</option>--}}
                            {{--@endforeach--}}
                            {{--</select>--}}
                            {{--</div>--}}

                            <div class="col-md-2">
                                <button  class="add-btn" type="submit">Search</button>
                            </div>
                        </div>
                        </form>
                    </div>

                </div>
            </div>
            <form action="{{route('ordered-product-assignTo-Supplier')}}" method="POST" onSubmit="document.getElementById('submit').disabled=true;">
                {{csrf_field()}}
                @if($data_valid)
                    <div class="alert alert-success alert-dismissible fade show session-message" role="alert">
                        <b> {{$data_valid}} </b>
                    </div>
                    @else
                    @if(!empty($start_date))
                        <div class="alert alert-success alert-dismissible fade show session-message" role="alert">
                            <b> Order list showed between {{\Carbon\Carbon::parse($start_date)->format('d M, Y')}} to {{\Carbon\Carbon::parse($end_date)->format('d M, Y')}} </b>
                        </div>
                    @endif
                @endif

            <div class="row">
                <div class="col-lg-12">
                    <div class="mr-table allproduct">
                        <table id="geniustable" class="">
                            <thead>
                            <tr>
                                <th width=""><input type="checkbox" class='checkall checkbox' id='checkall'> Select</th>
                                <th width="">Product name</th>
                                <th width="">Customer name/ID</th>
                                <th width="">Quantity</th>
                                <th width="">Pickup point</th>
                                {{--<th width="15%">Suppliers</th>--}}
                                <th width="">Order code</th>
                                {{--<th width="12%">Action</th>--}}
                            </tr>
                            </thead>
                            <tbody>
                                @php
                                    $n = 0;
                                @endphp
                                @foreach($orders as $order)
                                    @foreach($order->products as $products)
                                        <tr>
                                            <td><input class="delete_check" @if($products->pivot->status == 1) disabled @endif value="{{$products->id}},{{$products->name}},{{$products->pivot->totalQuantity}},{{$order->id}},{{$order->user_id}},{{$order->order_number}}" name="product_check[]" type="checkbox"></td>
                                            <td>{{$products->name}}</td>
                                            <td>{{$order->user_id}}</td>
                                            <td>{{$products->pivot->totalQuantity}}</td>
                                            <td>{{$order->pickup_location}}</td>
                                            {{--<td>--}}
                                                {{--@php--}}
                                                {{--$supplier_id = [];--}}
                                                {{--foreach ($products->supplier_product as $key=>$value){--}}
                                                    {{--if(!in_array($value->supplier_id, $supplier_id)){--}}
                                                        {{--$supplier_id[] = $value->supplier_id;--}}
                                                    {{--}--}}
                                                {{--}--}}
                                                {{--$suppliers = \App\Models\Supplier::whereIn('id',$supplier_id)->get();--}}
                                                {{--$n++;--}}
                                                {{--@endphp--}}
                                                {{--<select name="" id="supplier{{$n}}">--}}
                                                    {{--@if($suppliers != '')--}}
                                                        {{--@foreach($suppliers as $supplier)--}}
                                                            {{--<option value="{{$supplier->email}}">{{$supplier->name}}</option>--}}
                                                        {{--@endforeach--}}
                                                    {{--@else--}}
                                                        {{--<option value="">no supplier</option>--}}
                                                    {{--@endif--}}
                                                {{--</select>--}}
                                            {{--</td>--}}
                                            <td>{{$order->order_number}}</td>
                                            {{--<td>--}}
                                                {{--<div class="action-list">--}}
                                                    {{--<a href="javascript:;" id="send{{$n}}" class="send" data-email="" data-toggle="modal" data-target="#vendorform"><i class="fas fa-envelope"></i> Send</a>--}}
                                                    {{--<a href="" ><i class="fas fa-eye"></i>Details</a>--}}
                                                {{--</div>--}}
                                            {{--</td>--}}
                                        </tr>
                                        @endforeach
                                    @endforeach
                            </tbody>
                        </table>
                        <button class="add-btn" id="add_btn" type="submit">View</button>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>

    {{-- MESSAGE MODAL --}}
    <div class="sub-categori">
        <div class="modal" id="vendorform" tabindex="-1" role="dialog" aria-labelledby="vendorformLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="vendorformLabel">{{ __('Send Email') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid p-0">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="contact-form">
                                        <form id="emailreply">
                                            {{csrf_field()}}
                                            <ul>
                                                <li>
                                                    <input type="email" class="input-field eml-val" id="eml" name="to" placeholder="{{ __('Email') }} *" value="" required="">
                                                </li>
                                                <li>
                                                    <input type="text" class="input-field" id="subj" name="subject" placeholder="{{ __('Subject') }} *" required="">
                                                </li>
                                                <li>
                                                    <textarea class="input-field textarea" name="message" id="msg" placeholder="{{ __('Your Message') }} *" required=""></textarea>
                                                </li>
                                            </ul>
                                            <button class="submit-btn" id="emlsub" type="submit">{{ __('Send Email') }}</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ADD / EDIT MODAL --}}

    <div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="submit-loader">
                    <img  src="{{asset('assets/images/'.$gs->admin_loader)}}" alt="">
                </div>
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {{--<div class="col-md-3">--}}
                    {{--<select name="" id="" class="input-field">--}}
                        {{--<option value="">Select Supplier</option>--}}
                        {{--@foreach($suppliers as $supplier)--}}
                            {{--<option value="{{$supplier->id}}">{{$supplier->name}}</option>--}}
                        {{--@endforeach--}}
                    {{--</select>--}}
                {{--</div>--}}
                <div class="modal-body asd">
                    <table>
                        <tr>
                            <th></th>
                            <td></td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button"  class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('scripts')

    <script>
        var table = $('#geniustable').DataTable({
            "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]]
        });

        $('.send').on('click',function () {
           var sendId = this.id;
            var res = sendId.substring(4);
            var supplierEmail = $('#supplier'+res).find(":selected").val();
            $('#send'+res).data("email",supplierEmail);
        });

        // $('#add_btn').on('click',function () {
        //     $('.asd').html(" ");
        //     var array = $.map($('input[name="product_check"]:checked'), function(c){
        //         return c.value;
        //         // console.log(c.value);
        //
        //     });
        //     console.log(array);
        //     array.forEach((item,index)=>{
        //         $('.asd').append(`<table>
        //                             <tr>
        //                                 <th>${item}</th>
        //                                 <td>${item}</td>
        //                             </tr>
        //                         </table>`)
        //     });
        //
        // });


        $('#checkall').click(function(){
            if($(this).is(':checked')){
                $('.delete_check').prop('checked', true);
            }else{
                $('.delete_check').prop('checked', false);
            }
        });
    </script>
@endsection