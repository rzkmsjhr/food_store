<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 100; $i++) {

            $productName = ['Bagel','Bean','Caviar','Chili','Cupcake','Falafel','Gelato','Nacho','Nugget','Pancake','Pop Tart','Ricotta','Sesame','Sprinkles','Taco','Tater Tot
','Tuna','Twizzler','Whiskey','Wonton','Ambrosia','BonBon','Candy','Chai','Cinnamon','Cookie','Crumble','Custard','Honey','Juniper','Margarita','Mocha','Mozzarella','Muffin','Nutella','Olive','Penne','Rosemary
','Strawberry','Sugar','Biscuit','Caesar','Dill','Dumpling','Hoagie','Lasagna','Noodle'];

            $createdProduct = Product::create([
                'name'          => Arr::random($productName),
                'price'         => rand(10,100),
                'breed_id'      => rand(1,5),
            ]);

        }
    }
}
