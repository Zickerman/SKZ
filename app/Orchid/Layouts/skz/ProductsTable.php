<?php

namespace App\Orchid\Layouts\skz;

use App\Models\Category;
use App\Models\Product;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ProductsTable extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'products';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('name', 'Название')->cantHide()->sort()->width('150px'),
            TD::make('category_id', 'Категория/Подкатегория')->sort()->render(function ($product){
                return Category::where('id',$product->category_id)->first()->name;
            }),
            TD::make('description', 'Описание')->width('350px')->popover('Описание которое увидят на сайте')->cutString(100),
            TD::make('price', 'Цена')->cantHide(),
            TD::make('available', 'Доступность')->sort()->render(function (Product $product){
	            return $product->available ? '<img src="/img/available.png"/>' : '<img src="/img/unavailable.png"/>';
            })->align(TD::ALIGN_CENTER),
            TD::make('amount', 'Количество')->cantHide(),

            TD::make('action', 'Редактировать')->render(function (Product $product){
                return ModalToggle::make('Изменить')->modal('editProduct')->method('update')
                    ->modalTitle('Редактирование продукта' . $product->name)
                    ->asyncParameters([
                        'product' => $product->id
                    ]);
            }),

        ];
    }
}
