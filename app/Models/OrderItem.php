<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = 'order_item';

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function product()
    {
        return $this->belongsTo(Services::class, 'service_id');
    }
}
