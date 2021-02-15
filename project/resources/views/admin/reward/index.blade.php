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
                        <form id="" action="{{route('admin-reward-store')}}" method="POST" enctype="multipart/form-data">
                            {{csrf_field()}}

                            <div class="row pt-3 allproduct">
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="col-lg-5">
                                                    <p>Ten Point is equal to :</p> 
                                                </div>
                                                <div class="col-lg-3">
                                                    <input type="number" class="input-field" name="points_to_equal">
                                                </div>
                                                <div class="col-lg-4">
                                                    <p>Tk</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>  
                                </div>
                            </div>
                            <div class="row pt-3 condition">
                            <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-6">
                                    <h3>condition</h3>
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
                                                    <input type="number" class="input-field" placeholder="{{ __('100') }}" name="redeem_point_one_invoice[]">
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
                                                    <input type="number" class="input-field" placeholder="{{ __('100') }}" name="min_purchase_amount[]">
                                                </div>
                                                <div class="col-lg-3">
                                                    <p>Tk</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div  class="col-lg-12" id="add_new">

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 text-right">
                                    <button class="condition-btn " id="add_new_condition"  type="submit">{{ __('Add new condition') }}</button>
                                </div>
                            </div>
                            <div class="row pt-4">
                                <div class="col-lg-12 text-left">
                                    <button class="rewardSubmit-btn" type="submit">{{ __('Submit') }}</button>
                                </div>
                            </div>
                        </form>
                        </div>
                        <div class="row mt-5">
                            <div class="col-lg-12">
                                <h3>All Conditions</h3>
                                <div class="mr-table allproduct">

                                    @include('includes.admin.form-success')

                                    <div class="table-responsiv">
                                        @if($rewards != '')
                                            <h4>Ten Point is equal to {{$rewards[0]->points_to_equal}} Tk</h4>
                                            @endif
                                        <table id="geniustable" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                                            <thead>
                                            <tr>
                                                <th>{{ __('Sl#') }}</th>
                                                <th>{{ __('One Can redeem point (On One invoice)') }}</th>
                                                <th>{{ __('Minimum Purchase amount(Tk)') }}</th>
                                                <th>{{ __('Status') }}</th>
                                                <th>{{ __('Action') }}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @if($rewards != '')
                                                @foreach($rewards as $reward)
                                                    <tr>
                                                        <td>{{$loop->iteration}}</td>
                                                        <td>{{$reward->redeem_point_one_invoice}}</td>
                                                        <td>{{$reward->min_purchase_amount}}</td>
                                                        <td>
                                                            @if($reward->status == 1)
                                                                <a href="{{route('admin-reward-status',['id1' => $reward->id, 'id2' => 0])}}" class="btn btn-sm btn-success">Active</a>
                                                            @else
                                                                <a href="{{route('admin-reward-status',['id1' => $reward->id, 'id2' => 1])}}" class="btn btn-sm btn-danger">Deactivated</a>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <a href="{{route('admin-rewards-edit',$reward->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                                            <a href="{{route('admin-rewards-delete',$reward->id) }}" class="btn btn-sm btn-danger">Delete</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                @endif
                                            </tbody>
                                        </table>
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
<script type="text/javascript">
    var max_fields = 15;
    x=0;
    $("#add_new_condition").click(function(e){
        e.preventDefault();
        if(x<max_fields) {
            x++;
            $('#add_new').append('' +
                '                               <div class="col-lg-12">\n' +
                '                                    <div class="row">\n' +
                '                                        <div><h3>condition</h3></div><div class="col-lg-12">\n' +
                '                                            <div class="row">\n' +
                '                                                <div class="col-lg-4">\n' +
                '                                                    <p>One Can redeem point :</p> \n' +
                '                                                </div>\n' +
                '                                                <div class="col-lg-3">\n' +
                '                                                    <input type="number" class="input-field" placeholder="100" name="redeem_point_one_invoice[]">\n' +
                '                                                </div>\n' +
                '                                                <div class="col-lg-3">\n' +
                '                                                    <p>On One invoice</p>\n' +
                '                                                </div>\n <div class="col-lg-2"><button class="btn btn-sm btn-danger" id="row_remove"><i class="fa fa-remove"></i>Remove</button></div>' +
                '                                            </div>\n' +
                '                                        </div>\n' +
                '                                    \n' +
                '                                    \n' +
                '\n' +
                '                                    \n' +
                '                                        <div class="col-lg-12">\n' +
                '                                            <div class="row">\n' +
                '                                                <div class="col-lg-4">\n' +
                '                                                    <p>Minimum Purchase amount :</p> \n' +
                '                                                </div>\n' +
                '                                                <div class="col-lg-3">\n' +
                '                                                    <input type="number" class="input-field" placeholder="100" name="min_purchase_amount[]">\n' +
                '                                                </div>\n' +
                '                                                <div class="col-lg-3">\n' +
                '                                                    <p>Tk</p>\n' +
                '                                                </div>\n' +
                '                                            </div>\n' +
                '                                        </div>\n' +
                '                                    </div>   \n' +
                '                                </div>');


        }});

    $('#add_new').on("click","#row_remove", function(e){
        e.preventDefault();
        $(this).parent('div').parent().parent().parent().parent().remove();
        x--;
    });

    var table = $('#geniustable').DataTable({
    });

</script>
@endsection