<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\WasteLog;

class WasteLogSeeder extends Seeder {
    public function run(): void {
        $foods = ['米飯', '雞肉', '蔬菜', '牛肉', '魚', '麵條'];
        for ($i = 0; $i < 8; $i++) {
            WasteLog::create([
                'food_category' => $foods[array_rand($foods)],
                'weight' => round(rand(5, 30) / 10, 2),
                'image_path' => '/storage/wastes/placeholder.jpg',
                'suggestion' => '建議明日備料量減少 15%'
            ]);
        }
    }
}
