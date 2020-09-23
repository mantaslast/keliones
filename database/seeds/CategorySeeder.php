<?php

use Illuminate\Database\Seeder;
use App\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'Poilsinės kelionės' => 'poilsines-keliones',
            'Pažintinės kelionės' => 'pazintines-keliones',
            'Pramoginės kelionės' => 'pramogines-keliones',
            'Egzotinės kelionės' => 'egzotines-keliones'
        ];
    
        foreach($categories as $category => $seoName){
            Category::create([
                'name' => $category,
                'slug' => $seoName,
                'hidden' => 0
            ]);
        };
    }
}
