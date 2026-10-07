<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        // Tenants
        $tenantIds = [];
        for ($i = 0; $i < 10; $i++) {
            $tenantIds[] = DB::table('tenants')->insertGetId([
                'name' => $faker->company,
                'phone' => $faker->phoneNumber,
            ]);
        }

        // Nurseries
        $nurseryIds = [];
        foreach ($tenantIds as $tenantId) {
            for ($i = 0; $i < 2; $i++) {
                $nurseryIds[] = DB::table('nurseries')->insertGetId([
                    'name' => $faker->company . ' Nursery',
                    'address' => $faker->address,
                    'tenant_id' => $tenantId,
                ]);
            }
        }

        // Rooms
        $roomIds = [];
        foreach ($nurseryIds as $nurseryId) {
            for ($i = 0; $i < 3; $i++) {
                $roomIds[] = DB::table('rooms')->insertGetId([
                    'name' => $faker->word . ' Room',
                    'nursery_id' => $nurseryId,
                ]);
            }
        }

        // Staff
        $staffIds = [];
        foreach ($nurseryIds as $nurseryId) {
            for ($i = 0; $i < 5; $i++) {
                $staffIds[] = DB::table('staff')->insertGetId([
                    'first_name' => $faker->firstName,
                    'last_name' => $faker->lastName,
                    'role' => $faker->randomElement(['Teacher', 'Assistant', 'Manager']),
                    'nursery_id' => $nurseryId,
                ]);
            }
        }

        // Children
        $childIds = [];
        foreach ($nurseryIds as $nurseryId) {
            for ($i = 0; $i < 15; $i++) {
                $childIds[] = DB::table('children')->insertGetId([
                    'first_name' => $faker->firstName,
                    'last_name' => $faker->lastName,
                    'date_of_birth' => $faker->date(),
                    'guardian_contact' => $faker->phoneNumber,
                    'gender' => $faker->randomElement(['Male', 'Female']),
                    'guardian_name' => $faker->name,
                    'nursery_id' => $nurseryId,
                ]);
            }
        }

        // Room Attendances
        foreach ($childIds as $childId) {
            DB::table('room_attendances')->insert([
                'child_id' => $childId,
                'room_id' => $faker->randomElement($roomIds),
                'staff_id' => $faker->randomElement($staffIds),
                'check_in_time' => Carbon::now()->subHours(rand(1, 5)),
                'check_out_time' => Carbon::now(),
            ]);
        }
    }
}
