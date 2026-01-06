<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Information extends Model
{
    use HasFactory;

    protected $table = 'informations';

    protected $fillable = [
        'judul',
        'konten',
        'banner',
        'slug',
        'created_by',
        'is_published'
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    // Relationship: Information belongs to Admin (User)
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Auto-generate slug when creating
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($information) {
            if (empty($information->slug)) {
                $information->slug = Str::slug($information->judul);
            }
        });
    }
}
