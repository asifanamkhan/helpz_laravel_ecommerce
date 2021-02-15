@extends('layouts.admin')
@section('styles')

    <style>
        .CampaignSubmit-btn {
            background: #1f224f;
            width: 280px;
            height: 40px;
            color: #fff;
            font-size: 14px;
            border: 0px;
            margin-top: 15px;
            -webkit-transition: all 0.3s ease-in;
            -o-transition: all 0.3s ease-in;
            transition: all 0.3s ease-in;
            box-shadow: 0px 1px 14px rgba(0, 0, 0, 0.25);
            border-radius: 10px;
        }
        .allproduct{
            background:#ffffff;
            border-radius: 17px;
        }
    </style>

@endsection

@section('content')
    <div class="content-area">
        <div class="mr-breadcrumb">
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="heading">{{ __('Campaign details') }}</h4>
                    <ul class="links">
                        <li>
                            <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a>
                        </li>
                        <li>
                            <a href="{{ route('admin-campaign-index') }}">{{ __('Campaign rules') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('campaign-rules-view',$campaign->id) }}">{{ __('Campaign details') }}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show session-message" role="alert">
                <strong>{{ session('success') }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if (session('warning'))
            <div class="alert alert-danger alert-dismissible fade show session-message" role="alert">
                <strong>{{ session('warning') }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <div class="row allproduct">
            <div class="card-body">
            <div class="col-lg-12">
                <div class="body-area">

                    @include('includes.admin.form-error')

                        <form action="{{route('admin-campaign-update',$campaign->id)}}" method="POST" onSubmit="document.getElementById('submit').disabled=true;">
                            {{csrf_field()}}
                        <div class="col-md-3 row mt-3">
                            <label class="col-md-1">Edit</label>
                            <input type="checkbox" class="form-control col-md-4" id="xyz">
                        </div>

                        <table class="table table-bordered table-hover mt-2">
                            <tbody>
                            <tr>
                                <th>Campaign name</th>
                                <td>
                                    <select id="discount_type" name="discount_type" class="form-control flagSelect" disabled>
                                        <option @if($campaign->discount_type == 1) selected @endif value="1">Price discount</option>
                                        <option @if($campaign->discount_type == 2) selected @endif value="2">Cash back</option>
                                        <option @if($campaign->discount_type == 3) selected @endif value="3">Reward points</option>
                                    </select>
                                </td>
                                <th>Campaign Status</th>
                                <td>
                                    <select class="form-control flagSelect" name="status" id="status" disabled>
                                        <option @if($campaign->status == 1) selected @endif value="1">Active</option>
                                        <option @if($campaign->status == 0) selected @endif value="0">Deactivated</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>Campaign offer</th>
                                <td>
                                    <input name="offer" readonly class="form-control flag" type="text" value="{{$campaign->offer}}">
                                </td>
                                <th>Offer Available To</th>
                                <td>
                                    <select class="form-control flagSelect" disabled id="available_to" name="available_to">
                                        <option data-href="{{ route('admin-campaign-dropdown-load',1) }}" @if($campaign->available_to == 1) selected @endif value="1">Category</option>
                                        <option data-href="{{ route('admin-campaign-dropdown-load',2) }}" @if($campaign->available_to == 2) selected @endif value="2">Sub Category</option>
                                        <option data-href="{{ route('admin-campaign-dropdown-load',3) }}" @if($campaign->available_to == 3) selected @endif value="3">Child Category</option>
                                        <option data-href="{{ route('admin-campaign-dropdown-load',4) }}" @if($campaign->available_to == 4) selected @endif value="4">Product</option>
                                        <option data-href="{{ route('admin-campaign-dropdown-load',5) }}" @if($campaign->available_to == 5) selected @endif value="5">Member</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>Redemption count</th>
                                <td><input name="redemption_count" readonly class="form-control flag" type="text" value="{{$campaign->redemption_count}}"></td>
                                <th>Campaign Created at</th>
                                <td>{{($campaign->created_at)->format('d M, Y, g:i A')}} ({{$campaign->created_at->diffForHumans()}})</td>
                            </tr>
                            <tr>
                                <th>Start date</th>
                                <td>
                                    @php
                                        $start_date = \Carbon\Carbon::parse($campaign->start_date)->format('d M, Y');
                                    @endphp
                                    <div class="row">
                                        <div class="col-md-4">{{$start_date}}</div>
                                        <div class="col-md-8">
                                            <input type="date" class="form-control flag" readonly  name="start_date" value="{{$start_date}}" >
                                        </div>
                                    </div>
                                </td>
                                <th>Start time</th>
                                <td>
                                    @php
                                    $start_time = \Carbon\Carbon::parse($campaign->start_time)->format('h:i A');
                                    @endphp
                                    <div class="row">
                                        <div class="col-md-4">{{$start_time}}</div>
                                        <div class="col-md-8">
                                            <input type="time" class="form-control flag" readonly  name="start_time" value="{{$start_time}}" >
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>End date</th>
                                <td>
                                    @php
                                        $end_date = \Carbon\Carbon::parse($campaign->end_date)->format('d M, Y');

                                    @endphp
                                    <div class="row">
                                        <div class="col-md-4">{{$end_date}}</div>
                                        <div class="col-md-8">
                                            <input type="date" class="form-control flag" readonly  name="end_date" value="{{$end_date}}" >
                                        </div>
                                    </div>
                                </td>
                                <th>End time</th>
                                <td>
                                    @php

                                        $end_time = \Carbon\Carbon::parse($campaign->end_time)->format('h:i A');
                                    @endphp
                                    <div class="row">
                                        <div class="col-md-4">{{$end_time}}</div>
                                        <div class="col-md-8">
                                            <input type="time" class="form-control flag" readonly  name="end_time" value="{{$end_time}}" >
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <th>Specific time start</th>
                                <td>
                                    @php
                                        if($campaign->specific_time_start != ''){
                                            $specific_time_start = \Carbon\Carbon::parse($campaign->specific_time_start)->format('h:i A');
                                        }
                                        else{
                                            $specific_time_start = '--';
                                        }
                                    @endphp
                                    <div class="row">
                                        <div class="col-md-4">{{$specific_time_start}}</div>
                                        <div class="col-md-8">
                                            <input type="time" class="form-control flag" readonly  name="specific_time_start" value="{{$specific_time_start}}" >
                                        </div>
                                    </div>
                                </td>
                                <th>Specific time end</th>
                                <td>
                                    @php
                                        if($campaign->specific_time_end != ''){
                                            $specific_time_end = \Carbon\Carbon::parse($campaign->specific_time_end)->format('h:i A');
                                        }
                                        else{
                                            $specific_time_end = '--';
                                        }
                                    @endphp
                                    <div class="row">
                                        <div class="col-md-4">{{$specific_time_end}}</div>
                                        <div class="col-md-8">
                                            <input type="time" class="form-control flag" readonly  name="specific_time_end" value="{{$specific_time_end}}" >
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <h4><b>Specific Offer</b></h4>
                        <div class="row">
                            <div class="col-md-8 ">
                                <table id="geniustable" class=" table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>{{ __('Sl') }}</th>
                                        <th>{{ __('Name') }}</th>
                                        <th width="15%">{{ __('Action') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @if($campaign->available_to == 1)
                                            @foreach($campaign->campaign as $key=>$value)
                                                @php
                                                    $data = \App\Models\Category::find($value->specific_to)
                                                @endphp
                                                @if($data)
                                                    <tr>
                                                    <td>{{$key+1}}</td>
                                                    <td>{{$data->name}}</td>
                                                    <td>
                                                        <a class="btn btn-sm btn-danger" href="{{route('admin-campaign-specific-offer-delete',['id1' => $value->id, 'id2' => $campaign->id])}}">Delete</a>
                                                    </td>
                                                </tr>
                                                @endif
                                            @endforeach
                                        @elseif($campaign->available_to == 2)
                                            @foreach($campaign->campaign as $key=>$value)
                                                @php
                                                    $data = \App\Models\Subcategory::find($value->specific_to)
                                                @endphp
                                                @if($data)
                                                <tr>
                                                    <td>{{$key+1}}</td>
                                                    <td>{{$data->name}}</td>
                                                    <td>
                                                        <a class="btn btn-sm btn-danger" href="{{route('admin-campaign-specific-offer-delete',['id1' => $value->id, 'id2' => $campaign->id])}}" >Delete</a>
                                                    </td>
                                                </tr>
                                                @endif
                                            @endforeach
                                        @elseif($campaign->available_to == 3)
                                            @foreach($campaign->campaign as $key=>$value)
                                                @php
                                                    $data = \App\Models\Childcategory::find($value->specific_to)
                                                @endphp
                                                @if($data)
                                                <tr>
                                                    <td>{{$key+1}}</td>
                                                    <td>{{$data->name}}</td>
                                                    <td>
                                                        <a class="btn btn-sm btn-danger" href="{{route('admin-campaign-specific-offer-delete',['id1' => $value->id, 'id2' => $campaign->id])}}">Delete</a>
                                                    </td>
                                                </tr>
                                                @endif
                                            @endforeach
                                        @else
                                            @foreach($campaign->campaign as $key=>$value)
                                                @php
                                                    $data = \App\Models\Product::find($value->specific_to)
                                                @endphp
                                                @if($data)
                                                <tr>
                                                    <td>{{$key+1}}</td>
                                                    <td>{{$data->name}}</td>
                                                    <td>
                                                        <a class="btn btn-sm btn-danger" href="{{route('admin-campaign-specific-offer-delete',['id1' => $value->id, 'id2' => $campaign->id])}}">Delete</a>
                                                    </td>
                                                </tr>
                                                @endif
                                            @endforeach
                                        @endif

                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-4">
                                <div class="col-lg-12 pt-5">
                                    <h4 class="heading">{{ __('Specific Offer to') }}</h4>
                                </div>
                                <div class="col-lg-12">

                                    <select multiple id="specific_to" class="form-control flagSelect" disabled name="specific_to[]" >

                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 text-right">
                                        <button class="CampaignSubmit-btn flagSelect" id="submit" type="submit">{{ __('Submit') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

@endsection
@section('scripts')
    <script>
        $('#xyz').on('click',function () {
            if($('#xyz').prop("checked") == true){
                $('.flagSelect').prop("disabled",false);
            }
            else if($('#xyz').prop("checked") == false){
                $('.flagSelect').prop("disabled",true);
            }
        });
        $('#xyz').on('click',function () {
            if($('#xyz').prop("checked") == true){
                $('.flag').prop("readonly",false);
            }
            else if($('#xyz').prop("checked") == false){
                $('.flag').prop("readonly",true);
            }
        });

        $('#discount_type').on('change', function() {
            $("#offerType").val($("#discount_type option:selected").text());
        });

        //on available to slecte
        $('#available_to').on('change', function() {
            var link = $(this).find(':selected').attr('data-href');
            if(link != "")
            {
                $('#specific_to').load(link);
                $('#specific_to').prop('disabled',false);
            }

        });

        var table = $('#geniustable').DataTable({});

    </script>
@endsection