<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // ID user (admin_id atau umkm_id)
            $table->enum('user_type', ['admin', 'umkm']); // Tipe user
            $table->string('type'); // Type: umkm_verified, product_liked, product_sold, etc.
            $table->string('title'); // Judul notifikasi
            $table->text('message'); // Pesan notifikasi
            $table->json('data')->nullable(); // Data tambahan (product_id, umkm_id, dll)
            $table->string('link')->nullable(); // Link untuk redirect
            $table->boolean('is_read')->default(false); // Status baca
            $table->timestamps();

            // Index untuk performa query
            $table->index(['user_id', 'user_type', 'is_read']);
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
