<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Coupon;

class CouponsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create absolute coupon
        Coupon::create([
            'code' => 'ABSOLUTE10',
            'type' => 'absolute',
            'discount_amount' => 10.00,
        ]);

        // Create percent coupon
        Coupon::create([
            'code' => 'PERCENT20',
            'type' => 'percent',
            'discount_amount' => 20.00,
        ]);

        // Create magic coupon
        Coupon::create([
            'code' => 'MAGIC',
            'type' => 'magical',
        ]);
    }
}