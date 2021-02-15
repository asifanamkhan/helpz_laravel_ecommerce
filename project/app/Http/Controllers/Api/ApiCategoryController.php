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


class ApiCategoryController extends Controller
{

    public function productAscategories(Request $request)
    {
        if($request->category_id){
            $product = Product::with('galleries','campaign_relation')->where('category_id',$request->category_id)->get();
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
        elseif($request->subcategory_id){
            $product = Product::with('galleries','campaign_relation')->where('subcategory_id',$request->subcategory_id)->get();
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
        elseif($request->childcategory_id){
            $product = Product::with('galleries','campaign_relation')->where('childcategory_id',$request->childcategory_id)->get();
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
        else{
            return response()->json('not found');
        }
    }

    public function productSearch(Request $request){

        $search = Product::with('campaign_relation')
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

}
