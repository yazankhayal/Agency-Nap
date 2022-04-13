<?php

use Illuminate\Database\Seeder;

class Products extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        foreach (range(0,1) as $index){
            $i = $faker->image(public_path()."/upload/products");
            $i2 = 'upload/products/'.$i;
            $ranAm = $faker->numberBetween(1,100);
            \App\Products::create([
                'name' => $faker->catchPhrase,
                'sub_name' => $faker->catchPhrase,
                'summary' => $faker->paragraph,
                'language_id' => 1,
                'avatar' => $faker->image('public/upload/products',640,480, null, false),
                'price' => $ranAm,
                'new_price' => $faker->numberBetween(0,100),
                'category_id'=> $faker->numberBetween(1,12),
            ]);
        }
    }
}
