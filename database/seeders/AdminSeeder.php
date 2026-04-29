<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        Admin::updateOrCreate(
            ['username' => 'superadmin'],
            [
                'username' => 'superadmin',
                'password' => Hash::make(env('DEFAULT_SUPERADMIN_PASSWORD', 'ChangeMe-SuperAdmin-2026!')),
                'role' => 'super_admin',
            ]
        );
    }
}
