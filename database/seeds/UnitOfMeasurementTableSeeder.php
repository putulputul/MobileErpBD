<?php

use Illuminate\Database\Seeder;

class UnitOfMeasurementTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('unit_of_measurement')->insert([
                [
                    'name' => 'Kilogram',
                    'symbol' => 'Kg',
                ],
                [
                    'name' => 'Gram',
                    'symbol' => 'gm',
                ],
                [
                    'name' => 'Litre',
                    'symbol' => 'ltr',
                ],
                [
                    'name' => 'Milliliter',
                    'symbol' => 'mltr',
                ],
                [
                    'name' => 'Pc(s)',
                    'symbol' => 'Pc(s)',
                ],
                [
                    'name' => 'Dozen',
                    'symbol' => 'Dz',
                ],
                [
                    'name' => 'Hali',
                    'symbol' => 'hali',
                ],
                [
                    'name' => 'Cartoon',
                    'symbol' => 'ctn',
                ],
                [
                    'name' => 'Bag',
                    'symbol' => 'Bg',
                ],
                [
                    'name' => 'Mon',
                    'symbol' => 'mon',
                ]

            ]
        );
    }

}
