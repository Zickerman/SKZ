<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\ArticleImage;

class ArticlesImagesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('articles_images')->delete();
        $directory = public_path('article_photos/2023/11/13');
        if (is_dir($directory)) {
            $files = scandir($directory);

            foreach ($files as $file) {
                if ($file == '.' || $file == '..') {
                    continue;
                }

                $article_id = explode('_', pathinfo($file, PATHINFO_FILENAME), 2)[0];
                $extension = pathinfo($file, PATHINFO_EXTENSION);

                $image = new ArticleImage([
                    'article_id' => $article_id,
                    'image_name' => pathinfo($file, PATHINFO_FILENAME),
                    'image_path' => '2023/11/13/',
                    'extension' => $extension,
                    'priority' => 0,
                ]);

                $image->save();
            }
        }
    }

}
