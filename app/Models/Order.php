<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'ref',
        'session_id',
        'customer_name',
        'address',
        'phone',
        'email',
        'note',
        'sub_total',
        'delivery_fee',
        'total',
        'deliver_status',
    ];

    public function payment()
    {
        return $this->hasOne(OrderPayment::class, 'order_id', 'id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }
}
