<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'tshirt_id', 'quantity', 'total_price', 'user_id'
    ];

    public function tshirt()
    {
        return $this->belongsTo(Tshirt::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class); // Optional, if users are involved
    }
}
