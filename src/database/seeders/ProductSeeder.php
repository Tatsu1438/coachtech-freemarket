<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            [
                'name' => '腕時計',
                'price' => '15000',
                'brand' => 'Rolex',
                'description' => 'スタイリッシュなデザインのメンズ腕時計',
                'img_url' => 'storage/app/public/images/Armani+Mens+Clock.jpg',
                'condition' => '良好',
            ],
            [
                'name' => 'HDD',
                'price' => '5000',
                'brand' => '西芝',
                'description' => '高速で信頼性の高いハードディスク',
                'img_url' => 'storage/app/public/images/HDD+Hard+Disk.jpg',
                'condition' => '目立った傷や汚れなし',
            ],
            [
                'name' => 'たまねぎ3束',
                'price' => '300',
                'brand' => 'なし',
                'description' => '新鮮な玉ねぎ3束のセット',
                'img_url' => 'storage/app/public/images/iLoveIMG+d.jpg',
                'condition' => 'やや傷や汚れあり',
            ],
            [
                'name' => '革靴',
                'price' => '4000',
                'brand' => '',
                'description' => 'クラシックなデザインの革靴',
                'img_url' => 'storage/app/public/images/Leather+Shoes+Product+Photo.jpg',
                'condition' => '状態が悪い',
            ],
            [
                'name' => 'ノートPC',
                'price' => '45000',
                'brand' => '',
                'description' => '高性能なノートパソコン',
                'img_url' => 'storage/app/public/images/Living+Room+Laptop.jpg',
                'condition' => '良好',
            ],
            [
                'name' => 'マイク',
                'price' => '8000',
                'brand' => 'なし',
                'description' => '高音質のレコーディング用マイク',
                'img_url' => 'storage/app/public/images/Music+Mic+4632231.jpg',
                'condition' => '目立った傷や汚れなし',
            ],
            [
                'name' => 'ショルダーバッグ',
                'price' => '3500',
                'brand' => '',
                'description' => 'おしゃれなショルダーバッグ',
                'img_url' => 'storage/app/public/images/Purse+fashion+pocket.jpg',
                'condition' => 'やや傷や汚れあり',
            ],
            [
                'name' => 'タンブラー',
                'price' => '500',
                'brand' => 'なし',
                'description' => '使いやすいタンブラー',
                'img_url' => 'storage/app/public/images/Tumbler+souvenir.jpg',
                'condition' => '状態が悪い',
            ],
            [
                'name' => 'コーヒーミル',
                'price' => '4000',
                'brand' => 'Starbacks',
                'description' => '手動のコーヒーミル',
                'img_url' => 'storage/app/public/images/Waitress+with+Coffee+Grinder.jpg',
                'condition' => '良好',
            ],
            [
                'name' => 'メイクセット',
                'price' => '2500',
                'brand' => '',
                'description' => '便利なメイクアップセット',
                'img_url' => 'storage/app/public/images/外出メイクアップセット.jpg',
                'condition' => '目立った傷や汚れなし',
            ],
        ]);
    }
}
