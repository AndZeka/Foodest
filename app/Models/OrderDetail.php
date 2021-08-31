<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use App\Models\Product;

class OrderDetail extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'orders_details';

    public function order()
    {
        return $this->hasOne(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
