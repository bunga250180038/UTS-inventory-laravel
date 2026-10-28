<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'unit_price',
        'subtotal',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'unit_price' => 'decimal:2',
            'subtotal' => 'decimal:2',
        ];
    }

    // Pesanan induk.
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    // Produk yang dipesan.
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
