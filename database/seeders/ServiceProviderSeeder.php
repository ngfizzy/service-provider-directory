<?php

namespace Database\Seeders;

use App\Models\ServiceProvider;
use Illuminate\Database\Seeder;

class ServiceProviderSeeder extends Seeder
{
    public function run(): void
    {
        $providers = ServiceProvider::factory()
            ->count(100)
            ->make()
            ->toArray();
        ServiceProvider::insertOrIgnore($providers);
    }
}
