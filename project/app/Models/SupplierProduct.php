<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierProduct extends Model
{
    protected $fillable = ['supplier_id','product_id','created_at','updated_at'];

}
