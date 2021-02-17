<?php

namespace App\Http\Controllers\Admin;

use App\Models\CampaignRelation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Childcategory;
use App\Models\Product;
use App\Models\User;
use App\Models\Currency;
use App\Models\Campaign;
use Validator;
use DB;
use Datatables;
use Carbon\Carbon;

class CampaignController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    //*** GET Request
    public function index()
    {
        return view('admin.campaign.index');
    }


    public function datatables()
    {
        $datas = Campaign::orderBy('id','desc')->get();
        //--- Integrating This Collection Into Datatables
        return Datatables::of($datas)
            ->addColumn('discount_type', function(Campaign $data) {
                if($data->discount_type == 1){return 'Price discount';}
                elseif ($data->discount_type == 2 ){return 'Cash back';}
                else {return 'Reward points';}
            })
            ->addColumn('available_to', function(Campaign $data) {
                if($data->available_to == 1){return 'Category';}
                elseif ($data->available_to == 2 ){return 'Sub Category';}
                elseif ($data->available_to == 3 ){return 'Child Category';}
                else {return 'Product';}
            })
            ->addColumn('status', function(Campaign $data) {
                $class = $data->status == 1 ? 'drop-success' : 'drop-danger';
                $s = $data->status == 1 ? 'selected' : '';
                $ns = $data->status == 0 ? 'selected' : '';
                return '<div class="action-list"><select class="process select droplinks '.$class.'"><option data-val="1" value="'. route('admin-campaign-status',['id1' => $data->id, 'id2' => 1]).'" '.$s.'>Activated</option><option data-val="0" value="'. route('admin-campaign-status',['id1' => $data->id, 'id2' => 0]).'" '.$ns.'>Deactivated</option>/select></div>';
            })
            ->addColumn('offer', function(Campaign $data) {
                return $data->offer;
            })
            ->addColumn('start_date', function(Campaign $data) {
                $start_date = Carbon::parse($data->start_date)->format('d M, Y');
                $start_time = Carbon::parse($data->start_time)->format('h:i A');
                $date_time = $start_date.'  '.$start_time;
                return $date_time  ;
            })
            ->addColumn('end_date', function(Campaign $data) {
                $end_date = Carbon::parse($data->end_date)->format('d M, Y');
                $end_time = Carbon::parse($data->end_time)->format('h:i A');
                $date_time = $end_date.'  '.$end_time;
                return $date_time  ;
            })
            ->addColumn('action', function(Campaign $data) {
                return '<div>
                            <a class="btn btn-sm btn-success" href="'.route('campaign-rules-view',$data->id).'">View/Edit</a>
                    
                            <a href="javascript:;" data-href="' . route('campaign-rules-delete',$data->id) . '" data-toggle="modal" data-target="#confirm-delete" class="btn btn-sm btn-danger delete">Delete</a>
                        </div>';
            })
            ->rawColumns(['status','action'])
            ->toJson(); //--- Returning Json Data To Client Side
    }

    //*** POST Request
    public function store(Request $request)
    {
        //--- Validation Section

        $messages = array(
            'discount_type.required' => 'Campaign rules is required.',
            'offer.required' => 'offer is Required.',
            'available_to.required' => 'Available to field Category is Required.',
            'specific_to.required' => 'Specific to field is Required.',
            'start_date.required' => 'Start date field is Required.',
            'end_date.required' => 'End date field is Required.',
            'start_time.required' => 'Start time field is Required.',
            'end_time.required' => 'End time field is Required.',
        );
        $this->validate($request, array(
            'discount_type'      => 'required',
            'offer'      => 'required',
            'available_to'      => 'required',
            'specific_to'      => 'required',
            'start_date'      => 'required|before_or_equal:end_date',
            'start_time'      => 'required',
            'end_date'      => 'required|after_or_equal:start_time',
            'end_time'      => 'required',
        ), $messages);
        //--- Validation Section Ends

         //--- Logic Section

        $transactionResult  = DB::transaction(function () use ($request) {

            $data = new Campaign;

            $input = $request->all();
            $input['specific_to'] = implode(',', $request->specific_to);
            // Save Data
            $data->fill($input)->save();

//            $campaign_id = Campaign::latest()->first();
//            //dd($campaign_id->available_to);
//            foreach ($request->specific_to as $key => $value){
//                CampaignRelation::create([
//                    'campaign_id' => $campaign_id->id,
//                    'available_to' => $campaign_id->available_to,
//                    'specific_to' => $value,
//                ]);
//            }

        if($request->available_to == 1){
            //category
            $products = Product::whereIn('category_id',$request->specific_to)->get(['campaign_id','id']);
            foreach ($products as $product){
                if($product->campaign_id == ''){
                    $campaign_id = Product::findOrFail($product->id);
                    $campaign_id->campaign_id = $data->id;
                    $campaign_id->update();
                }

            }
        }
        elseif($request->available_to == 2){
            //sub category
            $products = Product::whereIn('subcategory_id',$request->specific_to)->get(['campaign_id','id']);
            foreach ($products as $product){
                if($product->campaign_id == ''){
                    $campaign_id = Product::findOrFail($product->id);
                    $campaign_id->campaign_id = 1;
                    $campaign_id->update();
                }

            }
        }
        elseif ($request->available_to == 3){
            //child category
            $products = Product::whereIn('childcategory_id',$request->specific_to)->get(['campaign_id','id']);
            foreach ($products as $product){
                if($product->campaign_id == ''){
                    $campaign_id = Product::findOrFail($product->id);
                    $campaign_id->campaign_id = 1;
                    $campaign_id->update();
                }

            }
        }
        elseif ($request->available_to == 4){
            //product
            $products = Product::whereIn('id',$request->specific_to)->get(['campaign_id','id']);
            foreach ($products as $product){
                if($product->campaign_id == ''){
                    $campaign_id = Product::findOrFail($product->id);
                    $campaign_id->campaign_id = 1;
                    $campaign_id->update();
                }

            }
        }
        elseif ($request->available_to == 5){
            //product
            dd(5);
        }

        },2);

       return back()->with('success','check the table bellow. if campaign is not created then some of your product you have select are already in under campaign. please deactivated or remove the campaign to start again');

    }
    public function dropdown($id){
        
        if($id == 1){
            $data = Category::where('status','=',1)->orderBy('id','desc')->get();
        }
        else if($id == 2){
            $data = Subcategory::where('status','=',1)->orderBy('id','desc')->get();
        }
        else if($id == 3){
            $data = Childcategory::where('status','=',1)->orderBy('id','desc')->get();
        }
        else if($id == 4){
            $data = Product::where('status','=',1)->orderBy('id','desc')->get();
        }
        else if($id == 5){
            $data = User::orderBy('id','desc')->get();;
        }
       return view('load.campaign',compact('data'));
    }

    public function campaignStatus($id1,$id2){
        $data = Campaign::findOrFail($id1);
        $data->status = $id2;
        $data->update();
    }

    public function campaignView($id){
        $campaign = Campaign::findOrFail($id);
        return view('admin.campaign.view',compact('campaign'));
    }

    public function adminCampaignSpecificOfferDelete($id1,$id2){
        $campaign = CampaignRelation::findOrFail($id1);
        $campaign->delete();
        return redirect()->route('campaign-rules-view',$id2)->with('success','Data delete successfully');
    }

    public function update(Request $request, $id){

        //--- Validation Section Starts
        $messages = array(
            'discount_type.required' => 'Campaign rules is required.',
            'offer.required' => 'offer is Required.',
            'available_to.required' => 'Available to field Category is Required.',
        );
        $this->validate($request, array(
            'discount_type' => 'required',
            'offer'  => 'required',
            'available_to' => 'required',
            'start_date'      => 'nullable|before_or_equal:end_date',
            'start_time'      => 'nullable',
            'end_date'      => 'nullable|after_or_equal:start_time',
            'end_time'      => 'nullable',
        ), $messages);

        //--- Validation Section Ends

        //--- Logic Section
        $data = Campaign::findOrFail($id);

        if($request->available_to != $data->available_to){
            $campaignRelations = CampaignRelation::where('campaign_id',$id)->get();
            foreach($campaignRelations as $campaignRelation){
                $campaignRelation->delete();
            }
            if($request->specific_to){
                foreach ($request->specific_to as $key => $value){
                    CampaignRelation::create([
                        'campaign_id' => $id,
                        'specific_to' => $value,
                        'available_to' => $request->available_to,
                    ]);
                }
            }
        }
        else{
            if($request->specific_to){
                foreach ($request->specific_to as $key => $value){
                    CampaignRelation::create([
                        'campaign_id' => $id,
                        'specific_to' => $value,
                        'available_to' => $request->available_to,
                    ]);
                }
            }
        }

        $data->update([
            'discount_type'=>$request->discount_type,
            'status'=>$request->status,
            'offer'=>$request->offer,
            'available_to'=>$request->available_to,
            'redemption_count'=>$request->redemption_count,
            'start_date'=>$request->start_date ?? $data->start_date,
            'end_date'=>$request->end_date ?? $data->end_date,
            'start_time'=>$request->start_time ?? $data->start_time,
            'end_time'=>$request->end_time ?? $data->end_time,
            'specific_time_start'=>$request->specific_time_start ?? $data->specific_time_start,
            'specific_time_end'=>$request->specific_time_end ?? $data->specific_time_end,
        ]);

        return redirect()->route('campaign-rules-view',$id)->with('success','Updated Successfully');
    }

    public function deleteCampaign($id){

        $campaign = Campaign::find($id);
        $campaign_relations = CampaignRelation::where('campaign_id',$id)->get();
        foreach($campaign_relations as $campaign_relation){
            $campaign_relation->delete();
        }
        $campaign->delete();
        $msg = 'Campaign Deleted Successfully.';
        return response()->json($msg);
    }
}
