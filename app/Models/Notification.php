<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_type',
        'type',
        'title',
        'message',
        'data',
        'link',
        'is_read'
    ];

    protected $casts = [
        'data' => 'array',
        'is_read' => 'boolean',
    ];

    // Relationship with User (Admin)
    public function admin()
    {
        return $this->belongsTo(User::class, 'user_id')->where('role', 'admin');
    }

    // Relationship with UMKM
    public function umkm()
    {
        return $this->belongsTo(Umkm::class, 'user_id');
    }

    // Scope untuk filter notifikasi admin
    public function scopeForAdmin($query, $adminId)
    {
        return $query->where('user_id', $adminId)
                     ->where('user_type', 'admin')
                     ->orderBy('created_at', 'desc');
    }

    // Scope untuk filter notifikasi UMKM
    public function scopeForUmkm($query, $umkmId)
    {
        return $query->where('user_id', $umkmId)
                     ->where('user_type', 'umkm')
                     ->orderBy('created_at', 'desc');
    }

    // Scope untuk notifikasi yang belum dibaca
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    // Helper method untuk mark as read
    public function markAsRead()
    {
        $this->update(['is_read' => true]);
    }

    // Helper method untuk format waktu relatif
    public function getTimeAgoAttribute()
    {
        return $this->created_at->diffForHumans();
    }
}
