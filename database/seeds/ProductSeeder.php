<?php

use Illuminate\Database\Seeder;

use App\Products;
use App\Stocks;
use App\Suppliers;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $supplier = Suppliers::create([
            'name' => 'Unilever'
        ]);

        $product = Products::create([
            'name' => 'Pond\'s Men Energy Charge Face Wash',
            'description' => 'Get set to give your skin a charge of energy! Formulated with potent ingredients such as coffee bean extracts & cooling menthol, Pond\'s Men Energy Charge face wash energizes tired, haggard skin to give your face a healthy and active glow.',
            'price_per_piece' => 150.00,
            'minimum_pieces_per_bulk' => 12,
            'remaining_quantity' => 100,
            'quantity_critical_level' => 25
        ]);

        Stocks::create([
            'product_id' => $product->id,
            'supplier_id' => $supplier->id,
            'quantity' => 100,
            'total_amount' => 12500.00,
            'expiration_date' => '2018-12-30'
        ]);

        $product = Products::create([
            'name' => 'Pond\'s Men White Boost Spot Clearing Scrub',
            'description' => 'Give your skin an instant whitening boost! Pond\'s Men White Boost Spot Clearing Scrub combines the goodness of White Ginseng Extract & Deep Scrub beads that rejuvenate and refresh the skin making it look bright & clear instantly.',
            'price_per_piece' => 150.00,
            'minimum_pieces_per_bulk' => 12,
            'remaining_quantity' => 100,
            'quantity_critical_level' => 25
        ]);

        Stocks::create([
            'product_id' => $product->id,
            'supplier_id' => $supplier->id,
            'quantity' => 100,
            'total_amount' => 12500.00,
            'expiration_date' => '2018-12-30'
        ]);
    }
}
