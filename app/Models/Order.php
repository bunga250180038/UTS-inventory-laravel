<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'buyer_id',
        'order_number',
        'customer_phone',
        'shipping_address',
        'notes',
        'total',
        'payment_method',
        'payment_status',
        'status',
        'sale_id',
        'confirmed_at',
    ];

    protected function casts(): array
    {
        return [
            'total' => 'decimal:2',
            'confirmed_at' => 'datetime',
        ];
    }

    /**
     * Pembeli yang membuat pesanan.
     */
    public function buyer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    /**
     * Daftar barang pada pesanan.
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Transaksi penjualan setelah pesanan disetujui.
     */
    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }
}
