<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeasonalBannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('seasonal_banners')->insert([
            ['label1' => 'Summer Sale', 'label2' => '20 % OFF', 'label3' => 'Apple Phones', 'image' => 'seasonal_banner/summer-sale.png', 'url' => '#', 'status' => 'Active'],
        ]);
    }
}
