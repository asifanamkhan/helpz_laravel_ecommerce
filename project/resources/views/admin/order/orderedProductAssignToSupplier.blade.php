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
            {{--<form action="{{route('ordered-product-assignTo-Supplier')}}" method="POST" onSubmit="document.getElementById('submit').disabled=true;">--}}
                {{csrf_field()}}
                <div class="row">
                    <div class="col-lg-12 ">
                        <div class="mr-table allproduct">
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>Product name</th>
                                    <th>Quantity</th>
                                    <th>Customer name</th>
                                    <th>Order number</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($allProducts)
                                @foreach($allProducts as $product)
                                    @php
                                        $ext = explode(',',$product);
                                    @endphp
                                    <tr>
                                        <td>{{$ext[1]}}</td>
                                        <td>{{$ext[2]}}</td>
                                        <td>{{$ext[4]}}</td>
                                        <td>{{$ext[5]}}</td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-lg-5">
                                    <select name="" id="supplier">
                                        @if($suppliers != '')
                                            @foreach($suppliers as $supplier)
                                                <option sup_id="{{$supplier->id}}" email="{{$supplier->email}}" phone="{{$supplier->phone}}" value="{{$supplier->email}}">{{$supplier->name}}</option>
                                            @endforeach
                                        @else
                                            <option value="">no supplier</option>
                                        @endif
                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    <button data-toggle="modal" data-target="#modal1" class="add-btn" id="add_btn" type="submit">View</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            {{--</form>--}}
        </div>
    </div>

     {{--ADD / EDIT MODAL--}}

    <div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="submit-loader">
                    <img  src="{{asset('assets/images/'.$gs->admin_loader)}}" alt="">
                </div>
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <div class="">
                        <form action="{{route('admin-order-product-supplier-print')}}" method="post" onSubmit="document.getElementById('order_placed').disabled=true;">
                            {{csrf_field()}}
                            <input type="hidden" value="{{ json_encode($allProducts)}}" name="allProducts">
                            <input type="hidden" value="" name="supplier_id" id="supplier_id">
                            <input type="hidden" value="{{ $invoice_no }}" name="invoice_id">
                            <button id="order_placed" class="btn btn-sm add-newProduct-btn print" type="submit">
                                <i class="fa fa-print"></i>
                                {{ __('Ordered placed and send mail') }}
                            </button>
                        </form>

                    </div>
                    {{--<div class="">--}}
                        {{--<a class="btn  add-newProduct-btn print" href=""--}}
                           {{--target="_blank"><i class="fa fa-envelope"></i> {{ __('Send Mail') }}</a>--}}
                    {{--</div>--}}
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="order-table-wrap">
                        <div class="invoice-wrap">
                            <div class="invoice__title">
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="invoice__logo text-left">
                                            <img src="{{ asset('assets/images/'.$gs->invoice_logo) }}" alt="woo commerce logo">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row invoice__metaInfo mb-4">
                                <div class="col-lg-4">
                                    <div class="invoice__orderDetails">
                                        <p><strong>{{ __('Supplier Information') }} </strong></p>
                                        <span ><strong>{{ __('Name') }} :</strong> <span id="modal_supplier_name"></span> </span><br>
                                        <span ><strong>{{ __('Email') }} :</strong> <span id="modal_supplier_email"></span> </span><br>
                                        <span ><strong>{{ __('Phone') }} :</strong> <span id="modal_supplier_phone"></span> </span><br>
                                        <span ><strong>{{ __('Shop name') }} :</strong> <span id="modal_supplier_phone"></span> </span><br>


                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="invoice__orderDetails">
                                        <p><strong>{{ __('Invoice details') }} </strong></p>
                                         <span ><strong>{{ __('Invoice no') }} :</strong> <span >{{$invoice_no}}</span> </span><br>
                                         <span ><strong>{{ __('Barcode') }} :</strong> <span ><svg id="barcode"></svg></span> </span><br>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="invoice_table">
                                        <div class="mr-table">
                                            <div class="table-responsive">
                                                <table id="example2" class="table table-hover dt-responsive" cellspacing="0" width="100%" >
                                                    <thead>
                                                    <tr>
                                                        <th width="25%">Product name</th>
                                                        <th width="15%">Quantity</th>
                                                        <th width="23%">Customer name</th>
                                                        <th width="17%">Order number</th>
                                                        <th width="20%">Bar code</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @php
                                                        $n = 0;
                                                    @endphp
                                                   @if($allProducts)
                                                       @foreach($allProducts as $product)
                                                           @php
                                                               $ext = explode(',',$product);
                                                               $totalQuantity = $totalQuantity+$ext[2];
                                                               $n++
                                                           @endphp
                                                           <tr>
                                                               <td>{{$ext[1]}}</td>
                                                               <td>{{$ext[2]}}</td>
                                                               <td>{{$ext[4]}}</td>
                                                               <td id="ordernumber{{$n}}">{{$ext[5]}}</td>
                                                               <td><svg id="ordercode{{$n}}"></svg></td>
                                                           </tr>
                                                       @endforeach
                                                       @endif
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="1">Total quantity</td>
                                                            <td  class="text-left">{{$totalQuantity}}</td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button"  class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                </div>
            </div>
        </div>
    </div>

     {{--MESSAGE MODAL--}}
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
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.3/dist/JsBarcode.all.min.js"></script>
    <script>

        $('#add_btn').on('click',function () {
            var supplierEmail = $('#supplier').find(":selected").attr('email');
            if(supplierEmail){
                var supplierPhone = $('#supplier').find(":selected").attr('phone');
                var supplierId = $('#supplier').find(":selected").attr('sup_id');
                var supplierName = $('#supplier').find(":selected").html();
                $('#modal_supplier_name').html(supplierName);
                $('#modal_supplier_email').html(supplierEmail);
                $('#modal_supplier_phone').html(supplierPhone);
                $('#supplier_id').val(supplierId);
            }
            else{
                alert('No supplier found. Please ad supplier first');
                $('#add_btn').prop('disabled',true);
            }

        });

        $("#btn").click(function () {
            //Hide all other elements other than printarea.
            $("#printarea").show();
            window.print();
        });

        var count = "{{$count}}";

        for (var i =1 ; i< count+1; i++){
            var c = $('#ordernumber'+i).html();
            $('#ordercode'+i).html(c);
            JsBarcode('#ordercode'+i, c, {
                format: "code128",
                width: 1,
                height: 15,
                displayValue: false
            });
        }

        JsBarcode("#barcode", "{{$invoice_no}}", {
            format: "code128",
            width: 1,
            height: 15,
            displayValue: false
        });

    </script>
@endsection