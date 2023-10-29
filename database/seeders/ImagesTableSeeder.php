<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Image;

class ImagesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('images')->delete();
        $directory = public_path('product_photos/2023/10/28');

        if (is_dir($directory)) {
            $files = scandir($directory);

            foreach ($files as $file) {
                if ($file == '.' || $file == '..') {
                    continue;
                }

                $product_id = explode('_', pathinfo($file, PATHINFO_FILENAME), 2)[0];

                $image = new Image([
                    'product_id' => $product_id,
                    'image_path' => '2023/10/28/',
                    'image_name' => $file,
                    'priority' => 0,
                ]);

                $image->save();
            }
        }
    }

}
