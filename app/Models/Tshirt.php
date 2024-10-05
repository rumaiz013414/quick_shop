<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tshirt extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'color', 'size', 'price', 'stock', 'description' ,'image'
    ];

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}

