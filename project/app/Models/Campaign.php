<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
     protected $fillable = ['status','discount_type','offer','available_to',
         'specific_to','redemption_count','start_date','end_date',
         'start_time','end_time','specific_time_start','specific_time_end'];

    public function campaign()
    {
        return $this->hasMany('App\Models\CampaignRelation','campaign_id');
    }
}
