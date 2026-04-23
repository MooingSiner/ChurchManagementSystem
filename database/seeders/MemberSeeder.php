<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Members;
use App\Models\Address;

class MemberSeeder extends Seeder
{
    public function run(): void
    {
        $members = [
            [
                'member_fname' => 'Andy Andrade II',
                'member_mname' => 'A',
                'member_lname' => 'Mina',
                'gender' => 'Male',
                'birth_date' => '2026-04-12',
                'email' => 'mina@gmail.com',
                'phone_number' => '0123456789',
                'street' => 'Matina',
                'city' => 'Davao',
                'province' => 'Davao Del Sur',
            ],
            [
                'member_fname' => 'Claudee',
                'member_mname' => 'A',
                'member_lname' => 'Galon',
                'gender' => 'Male',
                'birth_date' => '2026-04-01',
                'email' => 'claudee@gmail.com',
                'phone_number' => '0912387654',
                'street' => 'Mandug',
                'city' => 'Davao',
                'province' => 'Davao Del Sur',
            ],
            [
                'member_fname' => 'John',
                'member_mname' => 'M',
                'member_lname' => 'Doe',
                'gender' => 'Male',
                'birth_date' => '2006-03-21',
                'email' => 'johndoe@example.com',
                'phone_number' => '0912345678',
                'street' => '123 Main St',
                'city' => 'Davao',
                'province' => 'Davao Del Sur',
            ],
        ];

        foreach ($members as $data) {
            $member = Members::create([
                'member_fname' => $data['member_fname'],
                'member_mname' => $data['member_mname'],
                'member_lname' => $data['member_lname'],
                'gender' => $data['gender'],
                'birth_date' => $data['birth_date'],
                'email' => $data['email'],
                'phone_number' => $data['phone_number'],
            ]);

            Address::create([
                'street' => $data['street'],
                'city' => $data['city'],
                'province' => $data['province'],
                'member_id' => $member->member_id,
            ]);
        }
    }
}