<?php

namespace App\Http\Controllers\Admin;

use App\Classes\GeniusMailer;
use App\Classes\OrderMailSendToSupplier;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Generalsetting;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\OrderTrack;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\SupplierProduct;
use App\ProductAssignToSupplier;
use Carbon\Carbon;
use Datatables;
use Illuminate\Http\Request;
use DB;
use PDF;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    //*** JSON Request
    public function datatables($status)
    {
        if($status == 'pending'){
            $datas = Order::where('status','=','pending')->get();
        }
        elseif($status == 'processing') {
            $datas = Order::where('status','=','processing')->get();
        }
        elseif($status == 'completed') {
            $datas = Order::where('status','=','completed')->get();
        }
        elseif($status == 'declined') {
            $datas = Order::where('status','=','declined')->get();
        }
        else{
          $datas = Order::orderBy('id','desc')->get();  
        }
         
         //--- Integrating This Collection Into Datatables
         return Datatables::of($datas)
                            ->editColumn('id', function(Order $data) {
                                $id = '<a href="'.route('admin-order-invoice',$data->id).'">'.$data->order_number.'</a>';
                                return $id;
                            })
                            ->editColumn('pay_amount', function(Order $data) {
                                return $data->currency_sign . round($data->pay_amount * $data->currency_value , 2);
                            })
                            ->addColumn('action', function(Order $data) {
                                $orders = '<a href="javascript:;" data-href="'. route('admin-order-edit',$data->id) .'" class="delivery" data-toggle="modal" data-target="#modal1"><i class="fas fa-dollar-sign"></i> Delivery Status</a>';
                                return '<div class="action-list"><a href="' . route('admin-order-show',$data->id) . '" > <i class="fas fa-eye"></i> Details</a><a href="javascript:;" class="send" data-email="'. $data->customer_email .'" data-toggle="modal" data-target="#vendorform"><i class="fas fa-envelope"></i> Send</a><a href="javascript:;" data-href="'. route('admin-order-track',$data->id) .'" class="track" data-toggle="modal" data-target="#modal1"><i class="fas fa-truck"></i>Track Order</a>'.$orders.'</div>';
                            }) 
                            ->rawColumns(['id','action'])
                            ->toJson(); //--- Returning Json Data To Client Side
    }
    public function index()
    {
        return view('admin.order.index');
    }

    public function edit($id)
    {
        $data = Order::find($id);
        return view('admin.order.delivery',compact('data'));
    }


    //*** POST Request
    public function update(Request $request, $id)
    {

        //--- Logic Section
        $data = Order::findOrFail($id);

        $input = $request->all();
        if ($data->status == "completed"){

        // Then Save Without Changing it.
            $input['status'] = "completed";
            $data->update($input);
            //--- Logic Section Ends
    

        //--- Redirect Section          
        $msg = 'Status Updated Successfully.';
        return response()->json($msg);    
        //--- Redirect Section Ends     

    
            }else{
            if ($input['status'] == "completed"){
    
                $gs = Generalsetting::findOrFail(1);
                if($gs->is_smtp == 1)
                {
                    $maildata = [
                        'to' => $data->customer_email,
                        'subject' => 'Your order '.$data->order_number.' is Confirmed!',
                        'body' => "Hello ".$data->customer_name.","."\n Thank you for shopping with us. We are looking forward to your next visit.",
                    ];
    
                    $mailer = new GeniusMailer();
                    $mailer->sendCustomMail($maildata);                
                }
                else
                {
                   $to = $data->customer_email;
                   $subject = 'Your order '.$data->order_number.' is Confirmed!';
                   $msg = "Hello ".$data->customer_name.","."\n Thank you for shopping with us. We are looking forward to your next visit.";
                $headers = "From: ".$gs->from_name."<".$gs->from_email.">";
                   mail($to,$subject,$msg,$headers);                
                }
            }
            if ($input['status'] == "declined"){
                $gs = Generalsetting::findOrFail(1);
                if($gs->is_smtp == 1)
                {
                    $maildata = [
                        'to' => $data->customer_email,
                        'subject' => 'Your order '.$data->order_number.' is Declined!',
                        'body' => "Hello ".$data->customer_name.","."\n We are sorry for the inconvenience caused. We are looking forward to your next visit.",
                    ];
                $mailer = new GeniusMailer();
                $mailer->sendCustomMail($maildata);
                }
                else
                {
                   $to = $data->customer_email;
                   $subject = 'Your order '.$data->order_number.' is Declined!';
                   $msg = "Hello ".$data->customer_name.","."\n We are sorry for the inconvenience caused. We are looking forward to your next visit.";
                   $headers = "From: ".$gs->from_name."<".$gs->from_email.">";
                   mail($to,$subject,$msg,$headers);
                }
    
            }

            $data->update($input);

            if($request->track_text)
            {
                    $title = ucwords($request->status);
                    $ck = OrderTrack::where('order_id','=',$id)->where('title','=',$title)->first();
                    if($ck){
                        $ck->order_id = $id;
                        $ck->title = $title;
                        $ck->text = $request->track_text;
                        $ck->update();  
                    }
                    else {
                        $data = new OrderTrack;
                        $data->order_id = $id;
                        $data->title = $title;
                        $data->text = $request->track_text;
                        $data->save();            
                    }
    
    
            } 


         //--- Redirect Section          
         $msg = 'Status Updated Successfully.';
         return response()->json($msg);    
         //--- Redirect Section Ends    
    
            }



        //--- Redirect Section          
        $msg = 'Status Updated Successfully.';
        return response()->json($msg);    
        //--- Redirect Section Ends  


    }



    public function pending()
    {
        return view('admin.order.pending');
    }
    public function processing()
    {
        return view('admin.order.processing');
    }
    public function completed()
    {
        return view('admin.order.completed');
    }
    public function declined()
    {
        return view('admin.order.declined');
    }
    public function show($id)
    {
        $order = Order::findOrFail($id);
        $cart = unserialize(bzdecompress(utf8_decode($order->cart)));
        return view('admin.order.details',compact('order','cart'));
    }
    public function invoice($id)
    {
        $order = Order::findOrFail($id);
        $cart = unserialize(bzdecompress(utf8_decode($order->cart)));
        return view('admin.order.invoice',compact('order','cart'));
    }
    public function emailsub(Request $request)
    {
        //return response()->json('ok');
        $gs = Generalsetting::findOrFail(1);
        if($gs->is_smtp == 1)
        {
            $data = [
                    'to' => $request->to,
                    'subject' => $request->subject,
                    'body' => $request->message,
            ];

            $mailer = new GeniusMailer();
            $mailer->sendCustomMail($data);
        }
        else
        {
            $data = 0;
            $headers = "From: ".$gs->from_name."<".$gs->from_email.">";
            $mail = mail($request->to,$request->subject,$request->message,$headers);
            if($mail) {
                $data = 1;
            }
        }

        return response()->json($data);
    }

    public function printpage($id)
    {
        $order = Order::findOrFail($id);
        $cart = unserialize(bzdecompress(utf8_decode($order->cart)));
        return view('admin.order.print',compact('order','cart'));
    }

    public function license(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $cart = unserialize(bzdecompress(utf8_decode($order->cart)));
        $cart->items[$request->license_key]['license'] = $request->license;
        $order->cart = utf8_encode(bzcompress(serialize($cart), 9));
        $order->update();       
        $msg = 'Successfully Changed The License Key.';
        return response()->json($msg);
    }

    public function status($id,$status)
    {
        $mainorder = Order::findOrFail($id);

    }

    public function ManageOrder(){
        //$categories = Category::with('subs','subs.childs')->get();
        //$suppliers = Supplier::get();
        //$porducts = Product::get(['id','name']);
        $data_valid ="Present date order list";
        $orders = Order::whereDate('created_at', '=', Carbon::today()->toDateString())
            ->with('products')->whereHas('products', function($query) {
                $query->orderBy('products.name');
            })->get();

//        $supplier_id = [];
//        foreach($orders as $order){
//                foreach($order->products as $products){
//                foreach ($products->supplier_product as $key=>$value){
//                    if(!in_array($value->supplier_id, $supplier_id)){
//                        $supplier_id[] = $value->supplier_id;
//                    }
//                }
//            }
//        }
//        $suppliers = Supplier::whereIn('id',$supplier_id)->get();
//
//        dd($suppliers);
//
//
//        $orders = Order::whereDate('created_at', '=', Carbon::today()->toDateString())
//            ->with('products')->whereHas('products', function($query) {
//                $query->whereHas('supplier_product',function($query) {
//                    $query->where('supplier_id',5);
//                });
//            })->get();
//        dd($orders);


    return view('admin.order.manageorder',compact('orders','data_valid'));
    }

    public function orderedProductAssignToSupplier(Request $request){
        $invoice_no = str_random(4).time();
        $allProducts = $request->product_check;
        $product_id = [];
        $totalQuantity =0;
        if($allProducts){
            foreach ($allProducts as $product){
                $ext = explode(',',$product);
                array_push($product_id,$ext[0]);
            }

            $count = count($allProducts);
        }
        else{
            $count = 0;
        }

        $supplier_id = SupplierProduct::whereIn('product_id',$product_id)->get(['supplier_id']);
        $suppliers =Supplier::whereIn('id',$supplier_id)->get();
        return view('admin.order.orderedProductAssignToSupplier',compact('allProducts','suppliers','totalQuantity','invoice_no','count'));
    }
    public function adminOrderProductSupplierPrint(Request $request){

        $gs = Generalsetting::findOrFail(1);

        $allProducts = json_decode($request->allProducts);

        $supplier = Supplier::findOrFail($request->supplier_id);

        DB::transaction(function () use ($request,$allProducts) {

        foreach ($allProducts as $key=>$value){
            $ext = explode(',',$value);
            $data = new ProductAssignToSupplier();
            $data-> invoice_no = $request->invoice_id;
            $data->product_id = $ext[0];
            $data->product_name = $ext[1];
            $data->product_qty = $ext[2];
            $data->customer_id = $ext[4];
            $data->order_id = $ext[3];
            $data->supplier_id = $request->supplier_id;
            $data->save();

            $order_product = OrderProduct::where('product_id',$ext[0])
                ->where('order_id',$ext[3])->first();

            if($order_product){
                $order_product->status = 1;
                $order_product->update();
            }

            }
        },3);

        if($gs->is_smtp == 1)
        {
            $data = [
                'to' => $supplier->email,
                'type' => "new_order",
                'cname' => $supplier->name,
                'oamount' => "",
                'aname' => "",
                'aemail' => "",
                'wtitle' => "",
                'onumber' => $request->invoice_id,
            ];

            $mailer = new OrderMailSendToSupplier();
            $mailer->sendOrderMail($data,$request->invoice_id);
        }
        else
        {
            $to = $supplier->email;
            $subject = "Your Order Placed!!";
            $msg = "Hello ".$supplier->name."!\nYou have placed a new order.\nYour order number is ".$request->invoice_id.".Please wait for your delivery. \nThank you.";
            $headers = "From: ".$gs->from_name."<".$gs->from_email.">";
            mail($to,$subject,$msg,$headers);
        }

        return redirect()->route('manage-order-history');
    }

    public function adminManageOrderHistory(){
        return view('admin.order.manageorderHistory');
    }

    public function adminorderedproductassigntosupplierhistory(){

        $datas = ProductAssignToSupplier::groupBy('invoice_no')->orderBy('id','desc')->get();
        //--- Integrating This Collection Into Datatables
        return Datatables::of($datas)
            ->addColumn('invoice_no', function(ProductAssignToSupplier $data) {
                return $data->invoice_no;
            })
            ->addColumn('supplier_name', function(ProductAssignToSupplier $data) {
                $supplier_name = Supplier::findOrFail($data->supplier_id);
                return $supplier_name->name;
            })
            ->addColumn('action', function(ProductAssignToSupplier $data) {
                return '<div class="action-list">
                            <a href="' . route('admin-ordered-product-assign-to-supplier-details',$data->invoice_no) . '" class="edit" > <i class="fas fa-edit"></i>Details</a>
                            <a href="' . route('admin-orderedProductAssignToSupplierPrint',$data->invoice_no) . '" class="edit" > <i class="fas fa-edit"></i>Print Pdf</a>
 
                        </div>';
            })
            ->rawColumns(['invoice_no','supplier_name','action'])
            ->toJson(); //--- Returning Json Data To Client Side
    }

    public function adminorderedproductassigntosupplierdetails($id){
        $datas = ProductAssignToSupplier::where('invoice_no',$id)->get();
        return view('admin.order.manageorderDetails',compact('datas'));
    }

    public function adminorderedProductAssignToSupplierPrint($id){
        $datas = ProductAssignToSupplier::where('invoice_no',$id)->get();
        return view('admin.order.orderedProductAssignToSupplierPrint',compact('datas'));
    }
    public function orderedProductAssignToSupplierSearch(Request $request){

        //$categories = Category::with('subs','subs.childs')->get();
        //$suppliers = Supplier::get();
        //$porducts = Product::get(['id','name']);
        $start_date = $request->start_date;
        $end_date = $request->end_date;


        if($start_date){
            if($request->start_date < $request->end_date){
                $data_valid = null;
                $orders = Order::whereBetween('created_at', [$request->start_date, $request->end_date])
                    ->with('products')->whereHas('products', function($query) {
                        $query->orderBy('products.name');
                    })->get();
            }else{
                $data_valid ="End date must be grater then start date";
                $orders =[];
            }
        }
        else{
            $data_valid ="Present date order list";
            $orders = Order::whereDate('created_at', '=', Carbon::today()->toDateString())
                ->with('products')->whereHas('products', function($query) {
                    $query->orderBy('products.name');
                })->get();
        }

        //return redirect()->route('admin-order-manage');
        return view('admin.order.manageorder',compact('orders','start_date','end_date','data_valid'));

    }

}