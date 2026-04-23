<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use Illuminate\Support\Facades\DB;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        Event::insert([
            [
                'event_name' => 'Sunday Worship Service',
                'start_date' => '2026-04-20',
                'end_date' => '2026-04-20',
                'start_time' => '10:00:00',
                'end_time' => '12:00:00',
                'description' => 'Weekly worship service.',
                'type_id' => 1,
                'admin_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'event_name' => 'Wednesday Prayer Meeting',
                'start_date' => '2026-04-23',
                'end_date' => '2026-04-23',
                'start_time' => '19:00:00',
                'end_time' => '21:00:00',
                'description' => 'Mid-week prayer gathering.',
                'type_id' => 2,
                'admin_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'event_name' => 'Youth Fellowship',
                'start_date' => '2026-04-25',
                'end_date' => '2026-04-25',
                'start_time' => '15:00:00',
                'end_time' => '17:00:00',
                'description' => 'Youth bonding and activities.',
                'type_id' => 3,
                'admin_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}