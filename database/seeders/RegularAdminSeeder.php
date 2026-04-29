<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RegularAdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::updateOrCreate(
            ['username' => 'admin'],
            [
                'username' => 'admin',
                'password' => Hash::make(env('DEFAULT_ADMIN_PASSWORD', 'ChangeMe-Admin-2026!')),
                'role' => 'admin',
            ]
        );
    }
}
