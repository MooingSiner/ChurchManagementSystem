<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Type;

class TypeSeeder extends Seeder
{
    public function run(): void
    {
        Type::insert([
            [
                'type_name' => 'Worship Service',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type_name' => 'Prayer Meeting',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type_name' => 'Youth Fellowship',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type_name' => 'Thanks Giving',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}