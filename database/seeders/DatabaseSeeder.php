<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        DB::table('devices')->insert([
            [
                'name' => 'lampu1',
                'status' => false,
            ],
            [
                'name' => 'lampu2',
                'status' => false,
            ],
            [
                'name' => 'lampu3',
                'status' => false,
            ],
            [
                'name' => 'lampu4',
                'status' => false,
            ],
            [
                'name' => 'lampu5',
                'status' => false,
            ],
        ]
        );
    }
}
