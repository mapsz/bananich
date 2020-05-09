<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(OrderStatusesTableSeeder::class);
     
        self::orderStatuses();
        self::itemStatuses();
        self::containers();
        self::users();
        self::permissions();


    }

    public function users(){
        //Admin
        DB::table('users')->insert([
            'id' => '1',
            'email' => 'admin@ad.ad',
            'name' => "admin",
            'password' => '$2y$10$MGkdSt82aaE25UNsmU5KY.K6dCAoNkEw.PQIafIUGW9uamX/lo6SO',
        ]);

      
    }

    public function permissions(){
        //Permisions
        DB::table('permissions')->insert([
            'id' => '1',
            'name' => "admin",
        ]);

        DB::table('permissions')->insert([
            'id' => '2',
            'name' => "gruzka",
        ]);

        //perm - users
        DB::table('permission_user')->insert([
            'id' => 1,
            'user_id' => 1,
            'permission_id' => 1,
        ]);
    }

    public function containers(){
        DB::table('containers')->insert([
            'id' => '1',
            'name' => "Яжик",
        ]);        
        DB::table('containers')->insert([
            'id' => '2',
            'name' => "Фруктовка",
        ]);    
    }

    public function itemStatuses(){
        DB::table('item_statuses')->insert([
            'id' => '0',
            'name' => "Отменён",
        ]);
        DB::table('item_statuses')
            ->where('name', 'Отменён')
            ->update(['id' => 0]);
        DB::table('item_statuses')->insert([
            'id' => '1',
            'name' => "Доставлен",
        ]);
        DB::table('item_statuses')->insert([
            'id' => '100',
            'name' => "Готов к погрузке",
        ]);
        DB::table('item_statuses')->insert([
            'id' => '200',
            'name' => "Нет на складе",
        ]);
        DB::table('item_statuses')->insert([
            'id' => '300',
            'name' => "Погружен",
        ]);
        DB::table('item_statuses')->insert([
            'id' => '400',
            'name' => "Возврат",
        ]);
        
    }

    public function orderStatuses(){
        DB::table('order_statuses')->insert([
            'id' => '0',
            'name' => "Отменён",
        ]);
        DB::table('order_statuses')
            ->where('name', 'Отменён')
            ->update(['id' => 0]);

        DB::table('order_statuses')->insert([
            'id' => 900,
            'name' => "Заказ оформлен",
        ]);
        DB::table('order_statuses')->insert([
            'id' => 850,
            'name' => "Не поднимает трубку",
        ]);
        DB::table('order_statuses')->insert([
            'id' => 800,
            'name' => "Потверждён по телефону",
        ]);
        DB::table('order_statuses')->insert([
            'id' => 700,
            'name' => "Потверждён",
        ]);
        DB::table('order_statuses')->insert([
            'id' => 600,
            'name' => "Готов к сборке",
        ]);
        DB::table('order_statuses')->insert([
            'id' => 500,
            'name' => "Собирается",
        ]);
        DB::table('order_statuses')->insert([
            'id' => 400,
            'name' => "Требует досборки",
        ]);
        DB::table('order_statuses')->insert([
            'id' => 300,
            'name' => "Готов к отправки",
        ]);
        DB::table('order_statuses')->insert([
            'id' => 200,
            'name' => "Уехал",
        ]);
        DB::table('order_statuses')->insert([
            'id' => 100,
            'name' => "Возврат",
        ]);
        DB::table('order_statuses')->insert([
            'id' => 150,
            'name' => "Возвращен на склад",
        ]);
        DB::table('order_statuses')->insert([
            'id' => 1,
            'name' => "Успешен",
        ]);
    }
}
