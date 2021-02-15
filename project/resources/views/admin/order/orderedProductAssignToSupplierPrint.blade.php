<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="{{$seo->meta_keys}}">
    <meta name="author" content="GeniusOcean">

    <title>{{$gs->title}}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{asset('assets/print/bootstrap/dist/css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('assets/print/font-awesome/css/font-awesome.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{asset('assets/print/Ionicons/css/ionicons.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('assets/print/css/style.css')}}">
    <link href="{{asset('assets/print/css/print.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <link rel="icon" type="image/png" href="{{asset('assets/images/'.$gs->favicon)}}">
    <style type="text/css">
        @page { size: auto;  margin: 0mm; }
        @page {
            size: A4;
            margin: 0;
        }
        @media print {
            html, body {
                width: 210mm;
                height: 287mm;
            }

            html {

            }
            ::-webkit-scrollbar {
                width: 0px;  /* remove scrollbar space */
                background: transparent;  /* optional: just make scrollbar invisible */
            }
        }
    </style>
</head>
<body id="printarea" onload="window.print()">
<div class="invoice-wrap">
    <div class="order-table-wrap">
    <div class="invoice__title">
        <div class="row">
            <div class="col-sm-6">
                <div class="invoice__logo text-left">
                    <img src="{{ asset('assets/images/'.$gs->invoice_logo) }}" alt="woo commerce logo">
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="row invoice__metaInfo mb-4">
        <div class="col-lg-5">
            @if(!empty($datas))
                    @php
                        $supplier = \App\Models\Supplier::findOrFail($datas[0]->supplier_id);
                    @endphp
            <div class="invoice__orderDetails">
                <p><strong>{{ __('Supplier Information') }} </strong></p>
                <span ><strong>{{ __('Name') }} :</strong> {{$supplier->name}} </span><br>
                <span ><strong>{{ __('Email') }} :</strong> {{$supplier->email}} </span><br>
                <span ><strong>{{ __('Phone') }} :</strong> {{$supplier->phone}} </span><br>
                <span ><strong>{{ __('Shop name') }} :</strong> {{$supplier->shop_name}} </span><br>
            </div>

        </div>
        <div class="col-lg-6">
            <div class="invoice__orderDetails">
                <p><strong>{{ __('Purchase Order(P.O) Details') }} </strong></p>
                <span ><strong>{{ __('Purchase Order(P.O)') }} :</strong> <span >{{$datas[0]->invoice_no}}</span> </span><br>
                <div class="row">
                    <div class="col-lg-2">
                        <strong>{{ __('Barcode') }} :</strong>
                    </div>
                    <div class="col-lg-8">
                        <svg id="barcode"></svg>
                    </div>
                </div>
                <br>
            </div>
        </div>
        @endif
    </div>

    <div class="col-lg-12">
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
                            $totalQuantity = 0;
                        @endphp
                        @foreach($datas as $data)
                            @php
                                $totalQuantity = $data->product_qty;
                                $n++
                            @endphp
                            <tr>
                                <td>{{$data->product_name}}</td>
                                <td>{{$data->product_qty}}</td>
                                <td>{{$data->customer_id}}</td>
                                <td id="ordernumber{{$n}}">{{$data->order_id}}</td>
                                <td><svg id="ordercode{{$n}}"></svg></td>
                            </tr>
                            {{--<tr>--}}
                                {{--<td>{{$ext[1]}}</td>--}}
                                {{--<td>{{$ext[2]}}</td>--}}
                                {{--<td>{{$ext[4]}}</td>--}}
                                {{--<td id="ordernumber{{$n}}">{{$ext[5]}}</td>--}}
                                {{----}}
                            {{--</tr>--}}
                        @endforeach
                        </tbody>
                        <tfoot class="foot">
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
<!-- ./wrapper -->
<script
src="https://code.jquery.com/jquery-3.5.1.min.js"
integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.3/dist/JsBarcode.all.min.js"></script>
<script type="text/javascript">
    var count = "{{count($datas)}}";

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

    JsBarcode("#barcode", "{{$datas[0]->invoice_no}}", {
        format: "code128",
        width: 1,
        height: 15,
        displayValue: false
    });

    setTimeout(function () {
        window.close();
    }, 500);


    // $('#geniustable_filter').children('label').children('input').prop('autofocus',true);

</script>

</body>
</html>
