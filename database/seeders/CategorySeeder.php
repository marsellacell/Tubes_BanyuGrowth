<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'nama_kategori' => 'Makanan & Minuman',
                'slug' => 'makanan-minuman',
                'deskripsi' => 'Produk makanan dan minuman khas daerah'
            ],
            [
                'nama_kategori' => 'Fashion & Pakaian',
                'slug' => 'fashion-pakaian',
                'deskripsi' => 'Pakaian, aksesori, dan produk fashion'
            ],
            [
                'nama_kategori' => 'Kerajinan Tangan',
                'slug' => 'kerajinan-tangan',
                'deskripsi' => 'Kerajinan tangan dan produk handmade'
            ],
            [
                'nama_kategori' => 'Pertanian & Perkebunan',
                'slug' => 'pertanian-perkebunan',
                'deskripsi' => 'Produk pertanian dan hasil perkebunan'
            ],
            [
                'nama_kategori' => 'Jasa & Layanan',
                'slug' => 'jasa-layanan',
                'deskripsi' => 'Berbagai jasa dan layanan UMKM'
            ],
            [
                'nama_kategori' => 'Elektronik & Teknologi',
                'slug' => 'elektronik-teknologi',
                'deskripsi' => 'Produk elektronik dan teknologi'
            ],
            [
                'nama_kategori' => 'Kesehatan & Kecantikan',
                'slug' => 'kesehatan-kecantikan',
                'deskripsi' => 'Produk kesehatan dan kecantikan'
            ],
            [
                'nama_kategori' => 'Lainnya',
                'slug' => 'lainnya',
                'deskripsi' => 'Produk kategori lainnya'
            ],
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'nama_kategori' => $category['nama_kategori'],
                'slug' => $category['slug'],
                'deskripsi' => $category['deskripsi'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
