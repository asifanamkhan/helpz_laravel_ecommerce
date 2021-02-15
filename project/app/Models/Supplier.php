<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = ['name','email','phone','product_type','shop_name','status'];

    public function supplier_product()
    {
        return $this->hasMany('App\Models\SupplierProduct','supplier_id');
    }
}
