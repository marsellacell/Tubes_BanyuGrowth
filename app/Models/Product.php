<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'umkm_id',
        'category_id',
        'nama_produk',
        'harga',
        'deskripsi',
        'lokasi',
        'image',
        'jumlah_view',
        'jumlah_klik_beli',
        'jumlah_like',
        'status'
    ];

    protected $casts = [
        'harga' => 'decimal:2',
    ];

    // Relasi ke UMKM
    public function umkm(): BelongsTo
    {
        return $this->belongsTo(Umkm::class);
    }

    // Relasi ke Category
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi ke product clicks
    public function clicks(): HasMany
    {
        return $this->hasMany(ProductClick::class);
    }

    // Scope untuk produk aktif
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // Method untuk increment view
    public function incrementView()
    {
        $this->increment('jumlah_view');
    }

    // Method untuk increment klik beli
    public function incrementKlikBeli()
    {
        $this->increment('jumlah_klik_beli');
    }
}
