<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderTrack;
use App\Models\Product;
use App\Models\Reward;
use App\Models\User;
use App\Models\OrderProduct;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Input;
use Validator;
use DB;

class ApiOrderController extends Controller
{
    public function rewardCondition(){
        $reward = Reward::all();
        return response()->json($reward);
    }

    public function store(Request $request){

        $order_number = str_random(4).time();

        DB::transaction(function () use ($request,$order_number) {



        $order = new Order();
        $order['user_id'] = $request->user_id;
        //$order['cart'] = utf8_encode(bzcompress(serialize($cart), 9));
        $order['totalQty'] = count($request->ordered_products);
        $order['pay_amount'] = round($request->pay_amount );
        $order['method'] = $request->paymentMethod;
        $order['shipping'] = $request->shipping;
        $order['pickup_location'] = $request->pickup_location;
        $order['customer_email'] = $request->customer_email;
        $order['customer_name'] = $request->customer_name;
        $order['customer_phone'] = $request->customer_phone;
        //$order['shipping_cost'] = $request->shipping_cost;
        //$order['packing_cost'] = $request->packing_cost;
        //$order['tax'] = $request->tax;
        $order['order_number'] = $order_number;
        //$order['customer_address'] = $request->address;
        //$order['customer_country'] = $request->customer_country;
        //$order['customer_city'] = $request->city;
        //$order['customer_zip'] = $request->zip;
        //$order['shipping_email'] = $request->shipping_email;
        //$order['shipping_name'] = $request->shipping_name;
        //$order['shipping_phone'] = $request->shipping_phone;
        //$order['shipping_address'] = $request->shipping_address;
        //$order['shipping_country'] = $request->shipping_country;
        //$order['shipping_city'] = $request->shipping_city;
        //$order['shipping_zip'] = $request->shipping_zip;
        //$order['order_note'] = $request->order_notes;
        $order['coupon_code'] = $request->coupon_code;
        $order['coupon_discount'] = $request->coupon_discount;
        //$order['dp'] = $request->dp;
        $order['payment_status'] = "complete";
        $order['txnid'] = $request->txnid;
        //$order['currency_sign'] = $curr->sign;
        //$order['currency_value'] = $curr->value;
        //order['vendor_shipping_id'] = $request->vendor_shipping_id;
        //$order['vendor_packing_id'] = $request->vendor_packing_id;



        $user = User::findOrFail($request->user_id);
        if ($user)
        {
            $user->reward_points = $request->reward_points;
            $user->update();
        }
        $order->save();

        $track = new OrderTrack();
        $track->title = 'Pending';
        $track->text = 'You have successfully placed your order.';
        $track->order_id = $order->id;
        $track->save();

        $notification = new Notification();
        $notification->order_id = $order->id;
        $notification->save();

        if($request->coupon_id != "")
        {
            $coupon = Coupon::findOrFail($request->coupon_id);
            $coupon->used++;
            if($coupon->times != null)
            {
                $i = (int)$coupon->times;
                $i--;
                $coupon->times = (string)$i;
            }
            $coupon->update();

        }

        $or_id = Order::where('order_number',$order_number)->first();
        foreach($request->ordered_products as $prod)
        {
            $or = new OrderProduct();
            $or->order_id = $or_id->id;
            $or->product_id = $prod['id'];
            $or->price = $prod['price'];
            $or->totalQuantity = $prod['totalQuantity'];
            $or->totalPrice = $prod['totalPrice'];
            $or->status = 0;
            $or->save();
        }

//        foreach($request->ordered_products as $prod)
//        {
//
//            $x = (string)$prod['size_qty'];
//            if(!empty($x))
//            {
//                $product = Product::findOrFail($prod->id);
//                $x = (int)$x;
//                $x = $x - $prod['totalQuantity'];
//                $temp = $product->size_qty;
//                $temp[$prod['size_key']] = $x;
//                $temp1 = implode(',', $temp);
//                $product->size_qty =  $temp1;
//                $product->update();
//            }
//        }

        foreach($request->ordered_products as $prod)
        {
            $product = Product::findOrFail($prod['id']);
            $product->stock =  $product->stock - $prod['totalQuantity'];
            $product->update();
            if($product->stock <= 5)
            {
                $notification = new Notification;
                $notification->product_id = $product->id;
                $notification->save();
            }
        }
        }, 3);

        return response()->json($order_number);
    }

}
