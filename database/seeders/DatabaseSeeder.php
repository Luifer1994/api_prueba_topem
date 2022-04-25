<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Company;
use App\Models\DocumentType;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Company::factory(1)->create();
        DocumentType::factory(2)->create();
        Client::factory(20)->create();
        Product::factory(100)->create();
        User::factory(1)->create();
    }
}
