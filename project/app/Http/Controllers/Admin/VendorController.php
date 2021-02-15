<?php

namespace App\Http\Controllers\Admin;


use Datatables;
use App\Models\Admin;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Validator;
use DB;


class VendorController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth:admin');
    }

    //*** JSON Request
    public function datatables()
    {
         $datas = Admin::where('role','Vendor')->orderBy('id')->get();
         //--- Integrating This Collection Into Datatables
         return Datatables::of($datas)
                             ->addColumn('status', function(Admin $data) {
                                 if($data->status == 1){
                                     return '<a class="btn btn-sm btn-success" href="'. route('admin-vendor-status',['id1' => $data->id, 'id2' => 0]).'">Activated</a>';
                                 }
                                 else{
                                     return '<a class="btn btn-sm btn-danger" href="'. route('admin-vendor-status',['id1' => $data->id, 'id2' => 1]).'">Deactivated</a>';
                                 }
                             })
                            ->addColumn('action', function(Admin $data) {
                                $delete = $data->id == 1 ? '':'<a href="javascript:;" data-href="' . route('admin-vendor-delete',$data->id) . '" data-toggle="modal" data-target="#confirm-delete" class="delete"><i class="fas fa-trash-alt"></i></a>';
                                return '<div class="action-list"><a data-href="' . route('admin-vendor-show',$data->id) . '" class="view details-width" data-toggle="modal" data-target="#modal1"> <i class="fas fa-eye"></i>Details</a>'.$delete.'</div>';
                            })
                            ->rawColumns(['status','action'])
                            ->toJson(); //--- Returning Json Data To Client Side
    }

    //*** GET Request
  	public function index()
    {
        return view('admin.vendor.index');
    }

    //*** GET Request
    public function create()
    {
        return view('admin.vendor.create');
    }

    //*** POST Request
    public function store(Request $request)
    {
        //--- Validation Section
        $rules = [
               'photo'      => 'required|mimes:jpeg,jpg,png,svg',
                ];

        $validator = Validator::make(Input::all(), $rules);
        
        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends

        //--- Logic Section
        $data = new Admin();
        $input = $request->all();
        if ($file = $request->file('photo')) 
         {      
            $name = time().$file->getClientOriginalName();
            $file->move('assets/images/admins',$name);           
            $input['photo'] = $name;
        } 
        $input['role'] = 'Vendor';
        $input['password'] = bcrypt($request['password']);
        $data->fill($input)->save();
        //--- Logic Section Ends

        //--- Redirect Section        
        $msg = 'New Data Added Successfully.';
        return response()->json($msg);      
        //--- Redirect Section Ends    
    }

    //*** GET Request
    public function show($id)
    {
        $data = Admin::findOrFail($id);
        return view('admin.vendor.show',compact('data'));
    }

    //*** GET Request Delete
    public function destroy($id)
    {
    	if($id == 1)
    	{
        return "You don't have access to remove this admin";
    	}
        $data = Admin::findOrFail($id);
        //If Photo Doesn't Exist
        if($data->photo == null){
            $data->delete();
            //--- Redirect Section     
            $msg = 'Data Deleted Successfully.';
            return response()->json($msg);      
            //--- Redirect Section Ends     
        }
        //If Photo Exist
        if (file_exists(public_path().'/assets/images/admins/'.$data->photo)) {
            unlink(public_path().'/assets/images/admins/'.$data->photo);
        }
        $data->delete();
        //--- Redirect Section     
        $msg = 'Data Deleted Successfully.';
        return response()->json($msg);      
        //--- Redirect Section Ends    
    }

    public function status($id1,$id2){
        $data = Admin::findOrFail($id1);
        $data->status = $id2;
        $data->update();
        return view('admin.vendor.index');
    }
}
