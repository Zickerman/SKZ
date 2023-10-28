<?php

namespace App\Orchid\Screens\skz;

use App\Models\Category;
use App\Orchid\Layouts\skz\CategoriesTable;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\TextArea;
use Orchid\Support\Facades\Alert;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class Categories extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'categories' => Category::all(),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Категории СКЗ';
    }

    public function description(): ?string
    {
        return "Здесь вы можете добавить категорию/подкатегорию в базу данных. Это важно сделать перед добавлением товаров";
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('Добавить')->modal('createCategory')->method('create'),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            CategoriesTable::class,
            Layout::modal('createCategory', Layout::rows([
                Input::make('name')->required()->title('Название')->type('text'),
                Select::make('category_id')->fromModel(Category::class, 'name', 'id')
                    ->fromQuery(Category::whereNull('category_id'), 'name', 'id')->empty('')->title('Родительская категория'),
                TextArea::make('description')->title('Описание')->rows(5)->type('text'),
                CheckBox::make('available')->value(1)->title('Доступность')->help('Снимите галочку, если недоступно'),
            ]))->title('Добавить категорию/подкатегорию')->applyButton('Создать'),

            Layout::modal('editCategory', Layout::rows([
                Input::make('category.id')->type('hidden'),
                Input::make('category.name')->required()->title('Название категории/подкатегории')->type('text'),
                Select::make('category.category_id')->required()->fromModel(Category::class, 'name')
                    ->fromQuery(Category::whereNull('category_id'), 'name', 'id')->title('К какой категории относится'),
                TextArea::make('category.description')->title('Описание')->rows(3)->type('text'),
                Select::make('category.available')->required()->title('Доступность')->options(['1' => 'доступно', '0' => 'нет']),
            ]))->async('asyncGetCategory'),
        ];
    }

    public function asyncGetCategory(Category $category){
        return [
            'category' => $category,
        ];
    }
    public function update(Request $request){
        Category::find($request->input('category.id'))->update($request->category);
        Alert::success('Категория успешно обновлена');
    }

    public function create(Request $request){
        Category::create($request->merge([])->except('_token'));
        Alert::success('Категория успешно создана');
    }

    public function delete(Request $request){
        $categoryId = $request->input('category');
        $category = Category::find($categoryId);

        if ($category) {
            if ($category->children()->count() > 0) {
                // Если у категории есть дочерние подкатегории, выведите предупреждение и не удаляйте
                return redirect()->back()->with('warning', 'Эта категория имеет подкатегории. Удалите сначала подкатегории');
            } else {
                $category->delete();
                Alert::success('Категория успешно удалена');
            }
        } else {
            Alert::error('Категория не найдена');
        }
    }
}
