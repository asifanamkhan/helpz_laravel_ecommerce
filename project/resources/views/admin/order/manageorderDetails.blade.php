@extends('layouts.admin')

@section('styles')

@endsection


@section('content')
    <div class="content-area">
        <div class="mr-breadcrumb">
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="heading">{{ __('Order Details') }} <a class="add-btn" href="javascript:history.back();"><i class="fas fa-arrow-left"></i> {{ __('Back') }}</a></h4>
                    <ul class="links">
                        <li>
                            <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a>
                        </li>
                        <li>
                            <a href="javascript:;">{{ __('Orders') }}</a>
                        </li>
                        <li>
                            <a href="javascript:;">{{ __('Order Details') }}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="order-table-wrap">
            @if(!empty($datas))
                <table class="table table-bordered" >
                    <tr>
                        <th>Supplier name</th>
                        <td>
                            @php
                            $supplier_name = \App\Models\Supplier::findOrFail($datas[0]->supplier_id);
                            @endphp
                            {{$supplier_name->name}}
                        </td>
                        <td>Action</td>
                    </tr>
                    <tr>
                        <th>Purchase Order(P.O)</th>
                        <td>{{$datas[0]->invoice_no}}</td>
                        <td></td>
                    </tr>
                </table>
                @endif
            <table class="table table-bordered" >
                <thead>
                    <tr>
                        <th>Product name</th>
                        <th>Customer name</th>
                        <th>Quantity</th>
                        <th>Order no</th>
                    </tr>
                </thead>
                <tbody>
                @php
                $n=0;
                @endphp
                @foreach($datas as $data)
                    @php
                        $n=$n+$data->product_qty;
                    @endphp
                    <tr>
                        <td>{{$data->product_name}}</td>
                        <td>{{$data->customer_id}}</td>
                        <td>{{$data->product_qty}}</td>
                        <td>{{$data->order_id}}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="2" class="text-right"><b>Total</b></td>
                    <td><b>{{$n}}</b></td>
                    <td></td>
                </tr>
                </tfoot>
            </table>
        </div>



    </div>
    <!-- Main Content Area End -->

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

    {{-- MESSAGE MODAL ENDS --}}


@endsection


@section('scripts')

    <script type="text/javascript">
        var table = $('#geniustable').DataTable({
            "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]]
        });
    </script>

@endsection