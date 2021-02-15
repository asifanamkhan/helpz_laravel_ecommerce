<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Reward extends Authenticatable
{
    protected $guard = 'admin';

    protected $fillable = [
        'points_to_equal', 'redeem_point_one_invoice', 'min_purchase_amount', 'created_at', 'updated_at','status'
    ];


}
