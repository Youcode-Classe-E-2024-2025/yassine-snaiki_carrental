<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Rental;

class RentalSeeder extends Seeder {
    public function run(): void {
        Rental::factory(10)->create(); // Creates 10 fake rentals
    }
}
