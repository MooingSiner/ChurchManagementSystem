<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        DB::table('types')->upsert([
            ['type_id' => 1, 'type_name' => 'Worship Service', 'created_at' => $now, 'updated_at' => $now],
            ['type_id' => 2, 'type_name' => 'Prayer Meeting', 'created_at' => $now, 'updated_at' => $now],
            ['type_id' => 3, 'type_name' => 'Youth Fellowship', 'created_at' => $now, 'updated_at' => $now],
            ['type_id' => 4, 'type_name' => 'Thanks Giving', 'created_at' => $now, 'updated_at' => $now],
            ['type_id' => 5, 'type_name' => 'Bible Study', 'created_at' => $now, 'updated_at' => $now],
            ['type_id' => 6, 'type_name' => 'Community Outreach', 'created_at' => $now, 'updated_at' => $now],
            ['type_id' => 7, 'type_name' => 'Leadership Meeting', 'created_at' => $now, 'updated_at' => $now],
            ['type_id' => 8, 'type_name' => 'Church Anniversary', 'created_at' => $now, 'updated_at' => $now],
        ], ['type_id'], ['type_name', 'updated_at']);
    }
}
