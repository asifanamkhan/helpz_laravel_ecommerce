<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Datatables;
use App\Models\AdminLanguage;

class OfferAsProductController extends Controller
{
   public function index(){
        return view('admin.offer_as_product.index');
   }
}
