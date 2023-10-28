<?php

namespace App\Orchid\Screens\skz;

use App\Models\Category;
use App\Models\Product;
use App\Orchid\Layouts\skz\ProductsTable;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\TextArea;
use Orchid\Support\Facades\Alert;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class Products extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'products' => Product::filters()->defaultSort('name', 'desc')->paginate(10),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Товары СКЗ';
    }

    public function description(): ?string
    {
        return "Здесь вы можете добавить продукт в базу данных, который сразу отобразится на сайте";
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('Добавить продукт')->modal('createProduct')->method('create'),
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
            ProductsTable::class,
            Layout::modal('createProduct', Layout::rows([
                Input::make('name')->required()->title('Название')->type('text'),
                Select::make('category_id')->required()->fromModel(Category::class, 'name')
                    ->title('К какой категории/подкатегории относится')
                    ->popover('Сначала нужно заполнить категории/подкатегории, если здесь нет ни одной доступной для выбора'),
                TextArea::make('description')->title('Описание')->rows(7)->type('text'),
                Group::make([
                    Input::make('price')->required()->type('price')->title('Цена')->type('number'),
                    Input::make('amount')->required()->title('Количество')->type('number'),
                    Input::make('volume')->required()->title('Объем (л.)')->type('number')->min(0)->step(0.01)->placeholder('0.75'),
                    CheckBox::make('available')->value(1)->title('Доступность'),
                ]),
            ]))->title('Добавить продукт в базу данных')->applyButton('Создать'),

            Layout::modal('editProduct', Layout::rows([
                Input::make('product.id')->type('hidden'),
                Input::make('product.name')->required()->title('Название')->type('text'),
                Select::make('product.category_id')->required()->fromModel(Category::class, 'name')->title('К какой категории/подкатегории относится'),
                TextArea::make('product.description')->title('Описание')->rows(5)->type('text'),
                Group::make([
                    Input::make('product.price')->required()->type('price')->title('Цена')->type('number'),
                    Select::make('product.available')->required()->title('Доступность')->options([1 => 'да', 0 => 'нет']),
                    Input::make('product.amount')->required()->title('Количество')->type('number'),
                    Input::make('product.volume')->required()->title('Объем')->type('number')->min(0)->step(0.01),
                ]),
            ]))->async('asyncGetProduct'),
        ];
    }

    public function asyncGetProduct(Product $product){
        return [
            'product' => $product,
        ];
    }
    public function update(Request $request){
        Product::find($request->input('product.id'))->update($request->product);
        Alert::success('Товар успешно обновлен');
    }

    public function create(Request $request):void
    {
        $productData = $request->except('_token');

        $volume = (float) $productData['volume'];
        if ($volume < 0 || $volume > 99.999) {
            Alert::error('Товар не был сохранен. Проверьте введенные данные');
            return;
        }
        Product::create($productData);
        Alert::success('Товар успешно добавлен');
    }
}
