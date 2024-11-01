<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EgyptianCitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            ['name' => json_encode(['ar' => 'القاهرة', 'en' => 'Cairo'])],
            ['name' => json_encode(['ar' => 'الإسكندرية', 'en' => 'Alexandria'])],
            ['name' => json_encode(['ar' => 'الجيزة', 'en' => 'Giza'])],
            ['name' => json_encode(['ar' => 'الأقصر', 'en' => 'Luxor'])],
            ['name' => json_encode(['ar' => 'أسوان', 'en' => 'Aswan'])],
            ['name' => json_encode(['ar' => 'بورسعيد', 'en' => 'Port Said'])],
            ['name' => json_encode(['ar' => 'السويس', 'en' => 'Suez'])],
            ['name' => json_encode(['ar' => 'دمياط', 'en' => 'Damietta'])],
            ['name' => json_encode(['ar' => 'الإسماعيلية', 'en' => 'Ismailia'])],
            ['name' => json_encode(['ar' => 'شبين الكوم', 'en' => 'Shebin El Kom'])],
            // Add more cities as needed
        ];

        DB::table('cities')->insert($cities);
    }
}
