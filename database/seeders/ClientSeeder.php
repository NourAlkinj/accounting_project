<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $client1 = Client::create([

            'account_id'=> 5,
            'price_id'=> 1,
            'name'=>'client1',
            'is_customer'=> true,
            'is_vendor'=> false,
            'is_both_client'=> false,
            'address'=> 'lattakia',
            'birthday'=>'2000-01-12',
            'discount_ratio' => "0",
        ]);
        $client2 = Client::create([
            'account_id'=> 8,
            'price_id'=> 5,
            'is_customer'=> false,
            'is_vendor'=> true,
            'is_both_client'=> false,
            'address'=> 'homs',
            'discount_ratio' => "34",
        ]);
        $client2 = Client::create([
            'account_id'=> 6,
            'price_id'=> 3,
            'is_customer'=> false,
            'is_vendor'=> true,
            'is_both_client'=> false,
            'address'=> 'tartos',
            'discount_ratio' => "51",
        ]);
        $client3 = Client::create([
            'account_id'=> 9,
            'price_id'=> 2,
            'is_customer'=> false,
            'is_vendor'=> true,
            'is_both_client'=> false,
            'address'=> 'lattakia',
            'discount_ratio' => "77",
        ]);
        $client4 = Client::create([
            'account_id'=> 3,
            'price_id'=> 2,
            'is_customer'=> false,
            'is_vendor'=> true,
            'is_both_client'=> false,
            'address'=> 'lattakia',
            'discount_ratio' => "100",
        ]);


    }
}
