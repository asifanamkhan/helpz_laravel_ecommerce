<?php

namespace App\Http\Controllers\Admin;

use App\Models\Reward;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RewardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    //*** GET Request
    public function index()
    {
        $data = null;
        $rewards = Reward::orderBy('id','desc')->get();
        return view('admin.reward.index',compact('rewards','data'));
    }

    public function store(Request $request)
    {
        $messages = array(
            'points_to_equal.required' => 'Points to equal is required.',
            'redeem_point_one_invoice.required' => 'Redeem point one invoice is Required.',
            'min_purchase_amount.required' => 'Min purchase_amount field is Required.',

        );
        $this->validate($request, array(
            'points_to_equal'      => 'required',
            'redeem_point_one_invoice.*'      => 'required',
            'redeem_point_one_invoice'      => 'required|array|min:1',
            'min_purchase_amount.*'      => 'required',
            'min_purchase_amount'      => 'required|array|min:1',

        ), $messages);

        for ($i=0; $i < count($request->redeem_point_one_invoice) ; $i++) {
            $reward =  new Reward();

            $reward->redeem_point_one_invoice = $request->redeem_point_one_invoice[$i];
            $reward->min_purchase_amount = $request->min_purchase_amount[$i];
            $reward->status = 1;

            $reward->save();
        }

        $points_to_equals = Reward::get();

        foreach($points_to_equals as $points_to_equal){
            $points_to_equal->points_to_equal = $request->points_to_equal;
            $points_to_equal->update();
        }

        return back()->with('success','A reward condition create successfully');
    }

    public function status($id1,$id2){
        $data = Reward::findOrFail($id1);
        $data->status = $id2;
        $data->update();
        return back()->with('success','Status change successfully');
    }

    public function show($id){
        $data = Reward::findOrFail($id);
        return view('admin.reward.edit',compact('data'));
    }

    public function update(Request $request, $id){
        $messages = array(
            'redeem_point_one_invoice.required' => 'Redeem point one invoice is Required.',
            'min_purchase_amount.required' => 'Min purchase_amount field is Required.',

        );
        $this->validate($request, array(
            'redeem_point_one_invoice'      => 'required',
            'min_purchase_amount'      => 'required',

        ), $messages);

            $reward =  Reward::findOrFail($id);

            $reward->redeem_point_one_invoice = $request->redeem_point_one_invoice;
            $reward->min_purchase_amount = $request->min_purchase_amount;

            $reward->update();

        $points_to_equals = Reward::get();

        foreach($points_to_equals as $points_to_equal){
            $points_to_equal->points_to_equal = $request->points_to_equal;
            $points_to_equal->update();
        }


        return redirect()->route('admin-reward-index')->with('success','A updatedsuccessfully');
    }

    public function delete($id){
        $data = Reward::findOrFail($id);
        $data->delete();
        return back()->with('success','Deleted successfully');
    }


}
