<?php

namespace Database\Seeders;

use App\Models\ScoreProduct;
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
        // \App\Models\User::factory(10)->create();

        ScoreProduct::truncate();
        ScoreProduct::factory([
                                  'name'  => '邮件发送',
                                  'sku'   => 'score_mail',
                                  'price' => 1000,
                              ])->create();

        $this->call(CountryCodeSeeder::class);
    }
}
