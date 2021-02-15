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

                    </ul>
                </div>
            </div>
        </div>

        <div class="add-campaign-content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="product-description">
                        <h3>Campaign Rule</h3>
                        <div class="body-area">
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
                            @include('includes.admin.form-error')
                        <form id="" action="{{route('admin-campaign-store')}}" method="POST" onSubmit="document.getElementById('submit').disabled=true;">
                            {{csrf_field()}}

                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-12 pt-4">
                                            <select id="discount_type" name="discount_type" required>
                                                <option value="">Select Option</option>
                                                <option value="1">{{ __('Price Discount') }}</option>
                                                <option value="2">{{ __('Cash Back') }}</option>
                                                <option value="3">{{ __('Reward Point') }}</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-12 pt-5">
                                            <div class="row">
                                            <div class="col-lg-12">
                                                    <h4>{{ __('Offer') }}</h4>
                                                </div>
                                                <div class="col-lg-8">
                                                    <input id="offerType" type="text" class="input-field" value="" disabled>
                                                    <input id="" type="hidden" name="status" value="1" >
                                                </div>
                                                <div class="col-lg-4">
                                                    <input type="number" min=0 class="input-field" placeholder="{{ __('eg: 10%') }}" name="offer" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4 ">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <h4 class="heading">{{ __('Available to') }}</h4>
                                        </div>
                                        <div class="col-lg-12">
                                            <select  id="available_to" name="available_to" required>
                                                <option value="">Select Option</option>
                                                <option data-href="{{ route('admin-campaign-dropdown-load',1) }}" value="1">{{ __('Category') }}</option>
                                                <option data-href="{{ route('admin-campaign-dropdown-load',2) }}" value="2">{{ __('Sub Category') }}</option>
                                                <option data-href="{{ route('admin-campaign-dropdown-load',3) }}" value="3">{{ __('Child Category') }}</option>
                                                <option data-href="{{ route('admin-campaign-dropdown-load',4) }}" value="4">{{ __('Product') }}</option>
                                                <option data-href="{{ route('admin-campaign-dropdown-load',5) }}" value="5">{{ __('Member') }}</option>

                                            </select>
                                        </div>
                                        <div class="col-lg-12 pt-5">
                                            <h4 class="heading">{{ __('Specific Offer to') }}</h4>
                                        </div>
                                        <div class="col-lg-12">

                                            <select multiple id="specific_to" class="form-control" name="specific_to[]" required>

                                            </select>
                                        </div>
                                        <div class="col-lg-12 pt-5">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <h4 class="heading">{{ __('Redemption Count') }}</h4>
                                                </div>
                                                <div class="col-lg-12">
                                                   <input type="number" class="input-field" placeholder="{{ __('eg: 2') }}" min=0  name="redemption_count">
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <h4 class="heading">{{ __('Start Date') }}</h4>
                                        </div>
                                        <div class="col-lg-12">
                                             <input type="date" class="input-field"  name="start_date" required>
                                        </div>
                                    </div>

                                    <div class="row pt-5">
                                        <div class="col-lg-12">
                                            <h4 class="heading">{{ __('End Date') }}</h4>
                                        </div>
                                        <div class="col-lg-12">
                                            <input type="date" class="input-field"  name="end_date" required>
                                        </div>
                                    </div>

                                    <div class="row pt-5">
                                        <div class="col-lg-12">
                                            <h4 class="heading">{{ __('Specific Time Start') }}</h4>
                                        </div>
                                        <div class="col-lg-12">
                                            <input type="time" class="input-field"  name="specific_time_start" >
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <h4 class="heading">{{ __('Start Time') }}</h4>
                                        </div>
                                        <div class="col-lg-12">
                                             <input type="time" class="input-field"  name="start_time" required>
                                        </div>
                                    </div>

                                    <div class="row pt-5">
                                        <div class="col-lg-12">
                                            <h4 class="heading">{{ __('End Time') }}</h4>
                                        </div>
                                        <div class="col-lg-12">
                                            <input type="time" class="input-field"  name="end_time" required>
                                        </div>
                                    </div>

                                    <div class="row pt-5">
                                        <div class="col-lg-12">
                                            <h4 class="heading">{{ __('Specific Time End') }}</h4>
                                        </div>
                                        <div class="col-lg-12">
                                            <input type="time" class="input-field"  name="specific_time_end" >
                                        </div>
                                    </div>
                                </div>
                            </div>

                                <div class="row">
                                    <div class="col-lg-12 text-right">
                                        <button class="CampaignSubmit-btn" id="submit" type="submit">{{ __('Submit') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <div class="row mt-5">
                <div class="col-lg-12">
                <h3>Campaign:</h3>
                    <div class="mr-table allproduct">

                    @include('includes.admin.form-success')

                    <div class="table-responsiv">
                        <table id="geniustable" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>{{ __('Offer name') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Available to') }}</th>
                                <th>{{ __('Offer') }}</th>
                                <th>{{ __('Start date-time') }}</th>
                                <th>{{ __('End date-time') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- DELETE MODAL --}}

    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header d-block text-center">
                    <h4 class="modal-title d-inline-block">{{ __('Confirm Delete') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <p class="text-center">{{ __('You are about to delete this campaign. Everything under this campaign will be deleted') }}.</p>
                    <p class="text-center">{{ __('Do you want to proceed?') }}</p>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Cancel') }}</button>
                    <a class="btn btn-danger btn-ok">{{ __('Delete') }}</a>
                </div>

            </div>
        </div>
    </div>

    {{-- DELETE MODAL ENDS --}}


@endsection
@section('scripts')
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">

    //on discount type slecte
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

    var table = $('#geniustable').DataTable({
        ordering: false,
        processing: true,
        serverSide: true,
        ajax: '{{ route('campaign-rules-datatables') }}',
        columns: [
            { data: 'discount_type', name: 'discount_type' },
            { data: 'status', searchable: false, orderable: false},
            { data: 'available_to', name: 'available_to'},
            { data: 'offer', name: 'offer'},
            { data: 'start_date', name: 'start_date'},
            { data: 'end_date', name: 'end_date'},
            { data: 'action', searchable: false, orderable: false }

        ],
        language : {
            processing: '<img src="{{asset('assets/images/'.$gs->admin_loader)}}">'
        },
        drawCallback : function( settings ) {
            $('.select').niceSelect();
        }
    });

</script>
@endsection