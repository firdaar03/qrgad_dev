<?php

namespace Database\Seeders;

use App\Models\Table\Qrgad\MsFasilitasRuangan;
use App\Models\Table\Qrgad\MsLevel;
use App\Models\Table\Qrgad\MsLokasi;
use App\Models\Table\Qrgad\MsRuangan;
use App\Models\Table\Qrgad\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        User::create([
            'username' => '0121001',
            'password' => bcrypt('password'),
            'nama' => "DICKY NUGRAHA",
            'jabatan' => "Manager",
            'divisi' => "FA, BD & SC Division",
            'departemen' => "Finance & Accounting Department",
            'level' => "LV00000001",
            'status' => 1,
            'created_at' => now(),
            'created_by' => "firda"
        ]);

        User::create([
            'username' => '0121002',
            'password' => bcrypt('password'),
            'nama' => "FIRDA RISKA",
            'jabatan' => "Intern",
            'divisi' => "IT",
            'departemen' => "Digitalisasi",
            'level' => "LV00000002",
            'status' => 1,
            'created_at' => now(),
            'created_by' => "firda"
        ]);

        User::create([
            'username' => '0121003',
            'password' => bcrypt('password'),
            'nama' => "Dio Putra",
            'jabatan' => "Intern",
            'divisi' => "HR",
            'departemen' => "HRD",
            'level' => "LV00000003",
            'status' => 1,
            'created_at' => now(),
            'created_by' => "firda"
        ]);



        // User::create([
        //     'username' => '0121003',
        //     'password' => bcrypt('password'),
        //     'nama' => "Fikri",
        //     'jabatan' => "Intern",
        //     'divisi' => "Maintance",
        //     'departemen' => "Maintance",
        //     'level' => "LV00000004",
        //     'status' => 1,
        //     'created_at' => now(),
        //     'created_by' => "firda"
        // ]);

        User::create([
            'username' => '0121004',
            'password' => bcrypt('password'),
            'nama' => "Fikri",
            'jabatan' => "Intern",
            'divisi' => "Maintance",
            'departemen' => "Maintance",
            'level' => "LV00000004",
            'status' => 1,
            'created_at' => now(),
            'created_by' => "firda"
        ]);
        // User::factory(10)->create();

        MsLevel::create([
            'id' => "LV00000001",
            'level' => "Admin",
            'status' => 1,
            'created_at' => now(),
            'created_by' => "firda"
        ]);

        MsLevel::create([
            'id' => "LV00000002",
            'level' => "GAD",
            'status' => 1,
            'created_at' => now(),
            'created_by' => "firda"
        ]);

        MsLevel::create([
            'id' => "LV00000003",
            'level' => "Security",
            'status' => 1,
            'created_at' => now(),
            'created_by' => "firda"
        ]);

        MsLevel::create([
            'id' => "LV00000004",
            'level' => "User",
            'status' => 1,
            'created_at' => now(),
            'created_by' => "firda"
        ]);

        MsFasilitasRuangan::create([
            'id' => "FS00000001",
            'nama' => "AC",
            'status' => 1,
            'created_at' => now(),
            'created_by' => "firda"
        ]);

        MsFasilitasRuangan::create([
            'id' => "FS00000002",
            'nama' => "Kursi",
            'status' => 1,
            'created_at' => now(),
            'created_by' => "firda"
        ]);

        MsFasilitasRuangan::create([
            'id' => "FS00000003",
            'nama' => "Meja",
            'status' => 1,
            'created_at' => now(),
            'created_by' => "firda"
        ]);
       

        MsRuangan::create([
            'id' => "RG00000001",
            'nama' => "Ruang Digitalisasi",
            'lokasi' => "LK00000001",
            'lantai' => "3",
            'status' => 1,
            'kapasitas' => "20",
            'created_at' => now(),
            'created_by' => "firda"
        ]);

        MsRuangan::create([
            'id' => "RG00000002",
            'nama' => "Ruang IT",
            'lokasi' => "LK00000001",
            'lantai' => "3",
            'status' => 1,
            'kapasitas' => "20",
            'created_at' => now(),
            'created_by' => "firda"
        ]);

        MsLokasi::create([
            'id' => "LK00000001",
            'nama' => "Head Office",
            'status' => 1,
            'created_at' => now(),
            'created_by' => "firda"
        ]);

        MsLokasi::create([
            'id' => "LK00000002",
            'nama' => "Site",
            'status' => 1,
            'created_at' => now(),
            'created_by' => "firda"
        ]);

        MsLokasi::create([
            'id' => "LK00000003",
            'nama' => "Engineer",
            'status' => 1,
            'created_at' => now(),
            'created_by' => "firda"
        ]);
    }
}
