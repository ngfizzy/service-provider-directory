<?php

namespace Database\Seeders;

use App\Models\ServiceProvider;
use Illuminate\Database\Seeder;

class ServiceProviderSeeder extends Seeder
{
    public function run(): void
    {
        ServiceProvider::factory()->count(100)->create();
    }
}
