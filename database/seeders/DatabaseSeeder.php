<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use function Symfony\Component\Clock\now;

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
                'created_at' => now(),
            ],
            [
                'name' => 'lampu2',
                'status' => false,
                'created_at' => now(),
            ],
            [
                'name' => 'lampu3',
                'status' => false,
                'created_at' => now(),
            ],
            [
                'name' => 'lampu4',
                'status' => false,
                'created_at' => now(),
            ],
            [
                'name' => 'lampu5',
                'status' => false,
                'created_at' => now(),
            ],
        ]
        );
    }
}
