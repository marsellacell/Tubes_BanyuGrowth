<?php

namespace App\Services;

use App\Models\Notification;

class NotificationService
{
    /**
     * Create notification for UMKM verification
     */
    public static function umkmVerified($umkmId, $umkmName)
    {
        Notification::create([
            'user_id' => $umkmId,
            'user_type' => 'umkm',
            'type' => 'umkm_verified',
            'title' => '🎉 UMKM Anda Telah Diverifikasi!',
            'message' => "Selamat! {$umkmName} telah diverifikasi oleh admin. Anda sekarang dapat mengelola produk dan profil UMKM Anda.",
            'link' => '/umkm/dashboard',
            'is_read' => false
        ]);
    }

    /**
     * Notify admin when new UMKM registers
     */
    public static function umkmRegistered($adminId, $umkmName)
    {
        Notification::create([
            'user_id' => $adminId,
            'user_type' => 'admin',
            'type' => 'umkm_registered',
            'title' => '📝 UMKM Baru Mendaftar',
            'message' => "{$umkmName} telah mendaftar dan menunggu verifikasi Anda.",
            'link' => '/admin/umkm/pending',
            'is_read' => false
        ]);
    }

    /**
     * Notify UMKM when their product is liked
     */
    public static function productLiked($umkmId, $productName, $totalLikes)
    {
        Notification::create([
            'user_id' => $umkmId,
            'user_type' => 'umkm',
            'type' => 'product_liked',
            'title' => '❤️ Produk Anda Disukai!',
            'message' => "Produk \"{$productName}\" telah disukai oleh pembeli. Total {$totalLikes} suka.",
            'link' => '/umkm/products',
            'is_read' => false
        ]);
    }

    /**
     * Notify UMKM when their product is purchased/clicked buy
     */
    public static function productSold($umkmId, $productName, $totalPurchases)
    {
        Notification::create([
            'user_id' => $umkmId,
            'user_type' => 'umkm',
            'type' => 'product_sold',
            'title' => '🛒 Produk Anda Diminati!',
            'message' => "Ada pembeli yang tertarik dengan \"{$productName}\". Total {$totalPurchases} kali diklik beli.",
            'link' => '/umkm/products',
            'is_read' => false
        ]);
    }

    /**
     * Notify admin when UMKM adds new product
     */
    public static function productAdded($adminId, $umkmName, $productName)
    {
        Notification::create([
            'user_id' => $adminId,
            'user_type' => 'admin',
            'type' => 'product_added',
            'title' => '📦 Produk Baru Ditambahkan',
            'message' => "{$umkmName} menambahkan produk baru: \"{$productName}\".",
            'link' => '/admin/products',
            'is_read' => false
        ]);
    }

    /**
     * Notify admin when UMKM updates product
     */
    public static function productUpdated($adminId, $umkmName, $productName)
    {
        Notification::create([
            'user_id' => $adminId,
            'user_type' => 'admin',
            'type' => 'product_updated',
            'title' => '✏️ Produk Diperbarui',
            'message' => "{$umkmName} memperbarui produk: \"{$productName}\".",
            'link' => '/admin/products',
            'is_read' => false
        ]);
    }

    /**
     * Notify admin when UMKM updates their profile
     */
    public static function profileUpdated($adminId, $umkmName)
    {
        Notification::create([
            'user_id' => $adminId,
            'user_type' => 'admin',
            'type' => 'profile_updated',
            'title' => '👤 Profil UMKM Diperbarui',
            'message' => "{$umkmName} telah memperbarui informasi profil mereka.",
            'link' => '/admin/umkm',
            'is_read' => false
        ]);
    }

    /**
     * Notify UMKM when admin rejects their registration
     */
    public static function umkmRejected($umkmId, $umkmName, $reason = null)
    {
        $message = "Maaf, pendaftaran {$umkmName} tidak dapat disetujui.";
        if ($reason) {
            $message .= " Alasan: {$reason}";
        }

        Notification::create([
            'user_id' => $umkmId,
            'user_type' => 'umkm',
            'type' => 'umkm_rejected',
            'title' => '⚠️ Pendaftaran Ditolak',
            'message' => $message,
            'link' => '/umkm/profile/edit',
            'is_read' => false
        ]);
    }

    /**
     * Get all admins ID (for broadcasting notifications to all admins)
     */
    public static function getAllAdminIds()
    {
        return \App\Models\User::where('role', 'admin')->pluck('id')->toArray();
    }

    /**
     * Broadcast notification to all admins
     */
    public static function notifyAllAdmins($type, $title, $message, $link = null)
    {
        $adminIds = self::getAllAdminIds();
        
        foreach ($adminIds as $adminId) {
            Notification::create([
                'user_id' => $adminId,
                'user_type' => 'admin',
                'type' => $type,
                'title' => $title,
                'message' => $message,
                'link' => $link,
                'is_read' => false
            ]);
        }
    }
}
