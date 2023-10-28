<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('categories')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        Category::create([
            'category_id' => null,
            'name' => 'Соки',
            'description' => 'Разные соки на основе как фруктов/ягод так и овощей, например тыквенный или морковный,
                              а так же всевозможные сочетания фруктов ягод и овощей',
            'available' => 1,
        ]);

        Category::create([
            'category_id' => null,
            'name' => 'Консервы овощные',
            'description' => 'Разные овощные консервы как маринады так и соления',
            'available' => 1,
        ]);

        Category::create([
            'category_id' => null,
            'name' => 'Консервы фруктовые, ягодно-плодовые, овощные пюре',
            'description' => 'Разные консервы пюре, варенья, и т. д.',
            'available' => 1,
        ]);

        Category::create([
            'category_id' => 1,
            'name' => 'Соки фруктовые',
            'description' => 'Разные соки на основе фруктов и их сочетаниях',
            'available' => 1,
        ]);
        Category::create([
            'category_id' => 1,
            'name' => 'Соки содержащие овощи',
            'description' => 'Разные соки с овощными соками или полноценно изготовленные из овощей',
            'available' => 1,
        ]);

        Category::create([
            'category_id' => 2,
            'name' => 'Маринады и соления',
            'description' => 'Овощные маринады такие как маринованные огурцы, помидоры и т.д.',
            'available' => 1,
        ]);
        Category::create([
            'category_id' => 2,
            'name' => 'Заготовки',
            'description' => 'Соления такие как кабачковая икра, баклажанная и т.д.',
            'available' => 1,
        ]);

        Category::create([
            'category_id' => 3,
            'name' => 'Варенья, повидло, джемы',
            'description' => 'Пюре, варенья и т.д. состоящие из ягод и/или фруктов',
            'available' => 1,
        ]);
        Category::create([
            'category_id' => 3,
            'name' => 'Овощные пюре(либо с их добавлением)',
            'description' => 'Полноценно изготовленные из овощей, либо с добавлением таковых',
            'available' => 1,
        ]);

    }
}
