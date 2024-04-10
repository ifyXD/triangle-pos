<?php

namespace Modules\Product\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Product\Entities\Category;
use Modules\Setting\Entities\Unit;

class ProductDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // Category::create([
        //     'category_code' => 'CA_01',
        //     'category_name' => 'Random',
        //     'user_id' => 1
        // ]);

//        Unit::create([
//            'name' => 'Piece',
//            'short_name' => 'PC',
//            'operator' => '*',
//            'operation_value' => 1,
//            'user_id' => 1
//        ]);

        // Array of unit data
        $units = [
            [
                'name' => 'Piece',
                'short_name' => 'pc',
                'operator' => '*',
                'operation_value' => 1,
                'user_id' => 1
            ],
            [
                'name' => 'Gram',
                'short_name' => 'g',
                'operator' => '*',
                'operation_value' => 1,
                'user_id' => 1
            ],
            [
                'name' => 'Kilogram',
                'short_name' => 'kg',
                'operator' => '*',
                'operation_value' => 1000, // 1 kg = 1000 g
                'user_id' => 1
            ],
            [
                'name' => 'Metric ton',
                'short_name' => 't',
                'operator' => '*',
                'operation_value' => 1000000, // 1 t = 1000 kg = 1000000 g
                'user_id' => 1
            ],
            [
                'name' => 'Pound',
                'short_name' => 'lb',
                'operator' => '*',
                'operation_value' => 453.592, // 1 lb = 453.592 g
                'user_id' => 1
            ],
            [
                'name' => 'Ounce',
                'short_name' => 'oz',
                'operator' => '*',
                'operation_value' => 28.3495, // 1 oz = 28.3495 g
                'user_id' => 1
            ],
            [
                'name' => 'Liter',
                'short_name' => 'L',
                'operator' => '*',
                'operation_value' => 1000, // 1 L = 1000 mL
                'user_id' => 1
            ],
            [
                'name' => 'Milliliter',
                'short_name' => 'ml',
                'operator' => '*',
                'operation_value' => 1,
                'user_id' => 1
            ],
            [
                'name' => 'Cubic meter',
                'short_name' => 'm³',
                'operator' => '*',
                'operation_value' => 1000000, // 1 m³ = 1000 L = 1000000 mL
                'user_id' => 1
            ],
            [
                'name' => 'Cubic centimeter',
                'short_name' => 'cm³ or cc',
                'operator' => '*',
                'operation_value' => 1,
                'user_id' => 1
            ],
            [
                'name' => 'Gallon',
                'short_name' => 'gal',
                'operator' => '*',
                'operation_value' => 3785.41, // 1 gal = 3785.41 mL
                'user_id' => 1
            ],
            [
                'name' => 'Quart',
                'short_name' => 'qt',
                'operator' => '*',
                'operation_value' => 946.353, // 1 qt = 946.353 mL
                'user_id' => 1
            ],
            [
                'name' => 'Meter',
                'short_name' => 'm',
                'operator' => '*',
                'operation_value' => 1,
                'user_id' => 1
            ],
            [
                'name' => 'Centimeter',
                'short_name' => 'cm',
                'operator' => '*',
                'operation_value' => 0.01, // 1 cm = 0.01 m
                'user_id' => 1
            ],
            [
                'name' => 'Kilometer',
                'short_name' => 'km',
                'operator' => '*',
                'operation_value' => 1000, // 1 km = 1000 m
                'user_id' => 1
            ],
            [
                'name' => 'Inch',
                'short_name' => 'in',
                'operator' => '*',
                'operation_value' => 0.0254, // 1 in = 0.0254 m
                'user_id' => 1
            ],
            [
                'name' => 'Foot',
                'short_name' => 'ft',
                'operator' => '*',
                'operation_value' => 0.3048, // 1 ft = 0.3048 m
                'user_id' => 1
            ],
            [
                'name' => 'Yard',
                'short_name' => 'yd',
                'operator' => '*',
                'operation_value' => 0.9144, // 1 yd = 0.9144 m
                'user_id' => 1
            ],
        ];

        // Loop through the unit data and create records
        foreach ($units as $unit) {
            Unit::create($unit);
        }
    }
}
