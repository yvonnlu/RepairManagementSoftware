<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = 'order_item';

    protected $fillable = [
        'order_id',
        'service_id',
        'name',
        'qty',
        'price',
        'custom_description',
        'custom_device_type',
        'custom_issue_category',
        'custom_note'
    ];
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function product()
    {
        return $this->belongsTo(Services::class, 'service_id');
    }

    public function service()
    {
        return $this->belongsTo(Services::class, 'service_id');
    }
}
