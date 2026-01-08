<?php

namespace Database\Seeders;

use App\Models\YeastRegistration;
use Illuminate\Database\Seeder;

class YeastRegistrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        YeastRegistration::factory()->count(50)->create();
    }
}
