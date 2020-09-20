<?php

use Illuminate\Database\Seeder;
use App\MenuType;

class MenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {      
        MenuType::create(['name' => 'top']);
        MenuType::create(['name' => 'footer']);
        MenuType::create(['name' => 'mobile']);      
    }
}

