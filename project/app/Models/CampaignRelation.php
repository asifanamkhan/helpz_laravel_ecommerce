<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CampaignRelation extends Model
{
    protected $fillable = ['campaign_id','specific_to'];

    public function products()
    {
        return $this->belongsTo('App\Models\Product');
    }

    public function campaigns()
    {
        return $this->belongsTo('App\Models\CampaignRelation','id','campaign_id');
    }

}
