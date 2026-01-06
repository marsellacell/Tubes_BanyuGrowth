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
        Schema::table('umkms', function (Blueprint $table) {
            $table->renameColumn('nama', 'nama_lengkap');
        });
        
        Schema::table('umkms', function (Blueprint $table) {
            $table->string('nama_usaha')->after('nama_lengkap');
            $table->renameColumn('no_hp', 'no_telepon');
            $table->enum('status_verifikasi', ['pending', 'approved', 'rejected'])->default('pending')->after('password');
            $table->timestamp('verified_at')->nullable()->after('status_verifikasi');
            $table->foreignId('verified_by')->nullable()->constrained('users')->after('verified_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('umkms', function (Blueprint $table) {
            $table->dropForeign(['verified_by']);
            $table->dropColumn(['nama_usaha', 'status_verifikasi', 'verified_at', 'verified_by']);
            $table->renameColumn('no_telepon', 'no_hp');
            $table->renameColumn('nama_lengkap', 'nama');
        });
    }
};
