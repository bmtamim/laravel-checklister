<?php

namespace Database\Seeders;

use App\Models\Package;
use Faker\Factory;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Package::updateOrCreate([
            'name'          => 'Starter',
            'product_id'    => 'prod_JoVAmaSIubXbcY',
            'price_id'      => 'price_1JAs9qKsiuYSKlG5PpzJiGMe',
            'description'   => 'This is a starter package',
            'price'         => 20.00,
            'compare_price' => 25.10,
            'billing_type'  => 'monthly',
        ]);
        Package::updateOrCreate([
            'name'          => 'Standard',
            'product_id'    => 'prod_JoVGxvXd2Av52w',
            'price_id'      => 'price_1JAsGFKsiuYSKlG5ComYLoPp',
            'description'   => 'This is a standard package',
            'price'         => 100.00,
            'compare_price' => 145.50,
            'billing_type'  => 'quarterly',
        ]);
        Package::updateOrCreate([
            'name'          => 'Premium',
            'product_id'    => 'prod_JoVHLNLy4fdkva',
            'price_id'      => 'price_1JAsHCKsiuYSKlG5N4BpnKup',
            'description'   => 'This is a premium package',
            'price'         => 200.00,
            'compare_price' => 290.10,
            'billing_type'  => 'yearly',
        ]);
    }
}
