<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\CampaignRelation;
use App\Models\Category;
use App\Models\Product;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Session;
use Validator;
use DB;


class ApiCategoryController extends Controller
{

    public function productAscategories(Request $request)
    {
        if($request->category_id){


            $product = Product::where('category_id',$request->category_id)->with('campaign')->get();

            return response()->json($product);

        }
        elseif($request->subcategory_id){
            $data = [];
            $product = Product::with('galleries')->where('subcategory_id',$request->subcategory_id)->get();
            array_push($data,["product"=>$product]);
            $campaign_relation_data = CampaignRelation::where('available_to',2)->where('specific_to',$request->subcategory_id)->get();
            foreach ($campaign_relation_data as $key=>$value){
                $campaign_data = Campaign::where('id',$value->campaign_id)->where('status',1)->first();
                array_push($data,["campaign_data"=>$campaign_data]);
            }
            return response()->json($data);

        }
        elseif($request->childcategory_id){
            $data = [];
            $product = Product::with('galleries')->where('childcategory_id',$request->childcategory_id)->get();
            array_push($data,["product"=>$product]);
            $campaign_relation_data = CampaignRelation::where('available_to',3)->where('specific_to',$request->childcategory_id)->get();
            foreach ($campaign_relation_data as $key=>$value){
                $campaign_data = Campaign::where('id',$value->campaign_id)->where('status',1)->first();
                array_push($data,["campaign_data"=>$campaign_data]);
            }
            return response()->json($data);
        }
        elseif($request->product_id){
            $product = Product::with('campaign_relation','galleries')->where('id',$request->product_id)->get();
            if(!empty($product)){
                foreach ($product as $pro){
                    foreach ($pro->campaign_relation as $key=>$value){
                        $campaign = Campaign::findOrFail($value->campaign_id);
                        $pro->campaign_relation->push($campaign);
                    }
                }
                return response()->json($product);
            }
            else{
                return response()->json('not found');
            }
        }
    }

    public function productSearch(Request $request){

        $search = Product::with('campaign_relation','galleries')
        ->where('name','LIKE',"%{$request->name}%")->get();
        if(!empty($search)){
            foreach ($search as $pro){
                foreach ($pro->campaign_relation as $key=>$value){
                    $campaign = Campaign::findOrFail($value->campaign_id);
                    $pro->campaign_relation->push($campaign);
                }
            }
            return response()->json($search);
        }
        else{
            return response()->json('not found');
        }
    }

    public function wishListStore(Request $request){

    }
}
