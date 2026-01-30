<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Investor;
use App\Models\Fund;

class Investment extends Model
{
    protected $fillable = [
        'api_id',
        'uid',
        'start_date',
        'capital_amount',
        'status',
        'fund_id',
        'investor_id',
    ];

    public function investor()
    {
        return $this->belongsTo(Investor::class);
    }

    public function fund()
    {
        return $this->belongsTo(Fund::class);
    }
}
