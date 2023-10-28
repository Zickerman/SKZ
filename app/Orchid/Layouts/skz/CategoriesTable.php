<?php

namespace App\Orchid\Layouts\skz;

use App\Models\Category;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Alert;

class CategoriesTable extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'categories';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        if (session('warning')) {
            Alert::error(session('warning'));
        }

        return [
            TD::make('category_id', 'Категория')->sort()->render(function (Category $category){
                return $category->category_id ? $category->where('id', "$category->category_id")->first()->name : $category->name;
            }),
            TD::make('category_id', 'Подкатегория')->sort()->render(function (Category $category){
                return $category->category_id ? $category->name :  null;
            }),
            TD::make('description', 'Описание')->width('350px')->cutString(100),
            TD::make('available', 'Доступность')->sort()->render(function (Category $category){
	            return $category->available ? '<img src="/img/available.png"/>' : '<img src="/img/unavailable.png"/>';
            })->align(TD::ALIGN_CENTER),

            TD::make('action', 'Редактировать')->render(function (Category $category){
                return ModalToggle::make('Изменить')->modal('editCategory')->method('update')
                    ->modalTitle('Редактирование категории' . $category->name)
                    ->asyncParameters([
                        'category' => $category->id
                    ]);
            }),

            TD::make('delete', 'Удалить')->render(function (Category $category) {
                return Button::make('Удалить')->icon('trash')
                    ->confirm("<span style='color: #ff0000'>Будьте осторожны, т.к. удаление данной категори приведет к удалению всех записей принадлежащих ей!</span>")
                    ->method('delete')
                    ->parameters(['category' => $category->id]);
            }),

        ];
    }
}
