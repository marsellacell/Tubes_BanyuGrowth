<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Umkm extends Model
{
    use HasFactory;

    protected $table = 'umkms';

    protected $fillable = [
        'nama_lengkap',
        'nama_usaha',
        'email',
        'no_telepon',
        'username',
        'password',
        'logo_umkm',
        'status_verifikasi',
        'verified_at',
        'verified_by'
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
    ];

    // Relasi ke products
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    // Relasi ke admin yang memverifikasi
    public function verifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    // Relasi ke product clicks
    public function clicks(): HasMany
    {
        return $this->hasMany(ProductClick::class);
    }

    // Scope untuk UMKM yang sudah diverifikasi
    public function scopeVerified($query)
    {
        return $query->where('status_verifikasi', 'approved');
    }

    // Scope untuk UMKM yang menunggu verifikasi
    public function scopePending($query)
    {
        return $query->where('status_verifikasi', 'pending');
    }
}
