<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductClick extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'umkm_id',
        'ip_address',
        'user_agent',
        'click_type'
    ];

    // Relasi ke Product
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    // Relasi ke UMKM
    public function umkm(): BelongsTo
    {
        return $this->belongsTo(Umkm::class);
    }
}
