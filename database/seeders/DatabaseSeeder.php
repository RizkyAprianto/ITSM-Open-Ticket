<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Jaringan & WiFi', 'slug' => 'jaringan-wifi', 'description' => 'Kendala koneksi internet, wifi kampus, atau jaringan LAN.'],
            ['name' => 'Hardware & Perangkat', 'slug' => 'hardware', 'description' => 'Kerusakan fisik PC, printer, proyektor ruang kelas.'],
            ['name' => 'Software & Aplikasi', 'slug' => 'software', 'description' => 'Kendala instalasi software, error aplikasi, virus, dsb.'],
            ['name' => 'Sistem Akademik (SIAKAD)', 'slug' => 'siakad', 'description' => 'Lupa password, gagal login, KRS error, data tidak sinkron.'],
            ['name' => 'Layanan E-Learning', 'slug' => 'elearning', 'description' => 'Masalah pada platform Moodle, Zoom, atau Google Workspace Kampus.'],
            ['name' => 'Lainnya', 'slug' => 'lainnya', 'description' => 'Keluhan IT lain yang tidak masuk dalam kategori di atas.'],
        ];

        foreach ($categories as $cat) {
            \App\Models\Category::create($cat);
        }

        User::factory()->create([
            'name' => 'Admin Utama',
            'email' => 'admin@kampus.ac.id',
            'role' => 'admin',
        ]);
        
        User::factory()->create([
            'name' => 'Teknisi Jaringan',
            'email' => 'staff_1@kampus.ac.id',
            'role' => 'staff',
        ]);
    }
}
