<?php

namespace Database\Seeders;

use App\Models\Payment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder {
    public function run(): void {
        Payment::factory(10)->create(); // Creates 10 fake payments
    }
}
