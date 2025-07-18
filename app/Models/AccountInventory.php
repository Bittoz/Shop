<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountInventory extends Model
{
    protected $fillable = [
        'product_id',
        'username',
        'password',
        'note',
        'status',
        'order_id',
        'assigned_at',
        'delivered_at',
    ];

    protected $casts = [
        'assigned_at' => 'datetime',
        'delivered_at' => 'datetime',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
