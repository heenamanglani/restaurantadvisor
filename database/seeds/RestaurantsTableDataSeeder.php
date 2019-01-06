<?php

use Illuminate\Database\Seeder;
use App\Restaurants;

class RestaurantsTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $restaurants = [
            ['rest_name' => 'Ocean Basket', 'rest_address' => 'Ocean Basket, Main Road, Johannesburg Ward 87, Johannesburg, City of Johannesburg Metropolitan Municipality, Gauteng, 2001, RSA', 'tel_num'=> 9876543210,'lat' => -26.1775396, 'lng' => 28.001402],
            ['rest_name' => 'Calistos', 'rest_address' => 'Calisto\'s, Gill Street, Gillview, Johannesburg, South Africa', 'tel_num'=> 9876543211,'lat' => -26.2628556, 'lng' => 28.031163],
            ['rest_name' => 'Nando\'s', 'rest_address' => 'Nando\'s Comaro Crossing, Oakdene, Johannesburg South, South Africa', 'tel_num'=> 8876543211,'lat' => -26.266073, 'lng' => 28.059182],
            ['rest_name' => 'Little Italy', 'rest_address' => 'Little Italy, Glenanda, Johannesburg South, South Africa', 'tel_num'=> 8776543211,'lat' => -26.27549, 'lng' => 28.03827],
            ['rest_name' => 'Ginos Pizza', 'rest_address' => 'Gino\'s, Robertsham, Johannesburg, South Africa', 'tel_num'=> 8776543221,'lat' => -26.2472847, 'lng' => 28.0150671],
            ['rest_name' => 'Adega', 'rest_address' => 'Adega Alberton, Saint Austell Street, New Redruth, Alberton, South Africa', 'tel_num'=> 8776543222,'lat' => -26.2618131, 'lng' => 28.1131163],


        ];

        foreach ($restaurants as $status) {
            Restaurants::create(array(
                'rest_name' => $status["rest_name"],
                'rest_address' => $status["rest_address"],
                'tel_num' => $status["tel_num"],
                'lat' => $status["lat"],
                'lng' => $status["lng"],
            ));
        }

    }
}
