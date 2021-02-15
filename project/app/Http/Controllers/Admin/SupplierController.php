<?php

namespace App\Http\Controllers\Admin;

use App\Models\Supplier;
use App\Models\SupplierProduct;
use Datatables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Currency;
use Illuminate\Support\Facades\Input;
use Validator;

class SupplierController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    //*** JSON Request

    public function datatables()
    {
        $datas = Supplier::orderBy('id')->get();
        //--- Integrating This Collection Into Datatables
        return Datatables::of($datas)
            ->addColumn('action', function(Supplier $data) {
                $delete = $data->id == 0 ? '':'<a href="javascript:;" data-href="' . route('admin-supplier-delete',$data->id) . '" data-toggle="modal" data-target="#confirm-delete" class="delete"><i class="fas fa-trash-alt"></i></a>';
                return '<div class="action-list"><a data-href="' . route('admin-supplier-show',$data->id) . '" class="view details-width" data-toggle="modal" data-target="#modal1"> <i class="fas fa-eye"></i>Details</a>'.$delete.'</div>';
            })
            ->rawColumns(['action'])
            ->toJson(); //--- Returning Json Data To Client Side
    }

    public function index()
    {
        return view('admin.supplier.index');
    }

    //*** GET Request
    public function create()
    {
        return view('admin.supplier.create');
    }

    public function store(Request $request)
    {
        //--- Validation Section
        $rules = [
            'name' => 'required',
            'phone' => 'unique:suppliers|required',
            'product_type' => 'required',
        ];

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends


        //--- Logic Section
        $data = new Supplier();
        $input = $request->all();
        $data->fill($input)->save();
        //--- Logic Section Ends

        //--- Redirect Section
        $msg = 'New Data Added Successfully.';
        return response()->json($msg);
        //--- Redirect Section Ends
    }

    public function show($id)
    {
        $data = Supplier::findOrFail($id);
        return view('admin.supplier.show',compact('data'));
    }

    //*** GET Request Delete
    public function destroy($id)
    {
        $data = Supplier::findOrFail($id);

        $data->delete();

        $product_suppliers = SupplierProduct::where('supplier_id',$id)->get();
        foreach ($product_suppliers as $product_supplier){
            $product_supplier->delete();
        }
        //--- Redirect Section
        $msg = 'Data Deleted Successfully.';
        return response()->json($msg);
        //--- Redirect Section Ends
    }



}