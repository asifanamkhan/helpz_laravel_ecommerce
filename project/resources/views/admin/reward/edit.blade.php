@extends('layouts.admin')
@section('styles')

    <style>
        h3{
            font-weight:700;
        }
        .heading{
            font-size:16px;
        }
        select,.input-field {
            background: #FFFFFF;
            box-shadow: 0px 1px 14px rgba(0, 0, 0, 0.25);
            border-radius: 10px;
            padding:10px;
        }
        .rewardSubmit-btn, .edit-btn,.condition-btn {
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
        .edit-btn {
            width: 120px;
        }
        .condition-btn {
            width: 220px;
            height: 25px;
        }

        .condition{
            background:#ffffff;
            margin-top: 20px;
        }
        .condition .edit-btn {
            width: 60px;
            height: 30px;
        }
        .allproduct{
            background:#ffffff;
            border-radius: 17px;
        }
    </style>

@endsection

@section('content')
    <input type="hidden" id="headerdata" value="{{ __('Reward') }}">
    <div class="content-area">
        <div class="mr-breadcrumb">
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="heading">{{ __('Reward condition') }}</h4>
                    <ul class="links">
                        <li>
                            <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a>
                        </li>
                        <li>
                            <a href="{{ route('admin-reward-index') }}">{{ __('Reward Point condition') }}</a>
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
        <div class="add-campaign-content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="product-description">
                        <div class="body-area">
                            @include('includes.admin.form-error')
                            <form id="" action="{{route('admin-reward-update',$data->id)}}" method="POST" enctype="multipart/form-data">
                                {{csrf_field()}}

                                <div class="row allproduct">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-lg-5">
                                                <p>Ten Point is equal to :</p>
                                            </div>
                                            <div class="col-lg-3">
                                                <input type="number" class="input-field" name="points_to_equal" value="{{$data->points_to_equal}}">
                                            </div>
                                            <div class="col-lg-4">
                                                <p>Tk</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <p>One Can redeem point :</p>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <input type="number" class="input-field" placeholder="{{ __('100') }}" name="redeem_point_one_invoice" value="{{$data->redeem_point_one_invoice}}">
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <p>On One invoice</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <p>Minimum Purchase amount :</p>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <input type="number" class="input-field" placeholder="{{ __('100') }}" name="min_purchase_amount" value="{{$data->min_purchase_amount}}">
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <p>Tk</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row pt-4">
                                            <div class="col-lg-12 text-left">
                                                <button class="rewardSubmit-btn" type="submit">{{ __('Submit') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


     @endsection
        {{-- ADD / EDIT MODAL ENDS --}}


