<?php

namespace App\Orchid\Screens\skz;

use App\Models\Category;
use App\Models\Image as ProductImage;
use Intervention\Image\ImageManagerStatic as Images;
use App\Models\Product;
use App\Orchid\Layouts\skz\ProductsTable;
use Illuminate\Http\Request;
use Orchid\Attachment\Models\Attachment;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\Upload;
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
                Upload::make('images')->title('Фотографии продукта')->multiple()->acceptedFiles('image/*')
                    ->maxFiles(5)->groups('photo')->hint('Вы можете загрузить до 5 фотографий.')->storage('product_photos'),
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
                Upload::make('images')->title('Фотографии продукта')->multiple()->acceptedFiles('image/*')
                    ->maxFiles(5)->groups('photo')->hint('Вы можете загрузить до 5 фотографий.')->storage('product_photos'),
            ]))->async('asyncGetProduct'),
        ];
    }

    public function asyncGetProduct(Product $product){
        return [
            'product' => $product,
        ];
    }
    public function update(Request $request){
        $productId = $request->input('product.id');
        $product = Product::find($productId);

        if (!$product) {
            Alert::error('Товар не найден');
            return;
        }

        $product->update($request->product);

        $newPhotoIds = $request->input('images');

        if (is_array($newPhotoIds)) {
            foreach ($newPhotoIds as $newPhotoId) {
                try {
                    $attachment = Attachment::findOrFail($newPhotoId);
                    $imagePath = 'product_photos/' . $attachment->path . $attachment->name . '.' . $attachment->extension;

                    $img = Images::make($imagePath);
                    $img->fit(270, 370);
                    $img->save($imagePath);

                    $productImage = ProductImage::where('product_id', $product->id)
                        ->update([
                            'image_name' => $attachment->name,
                            'image_path' => $attachment->path,
                            'extension' => $attachment->extension,
                        ]);

                    if (!$productImage) {
                        $productImage = new ProductImage([
                            'product_id' => $product->id,
                            'image_name' => $attachment->name,
                            'image_path' => $attachment->path,
                            'extension' => $attachment->extension,
                        ]);

                        $productImage->save();
                    }

                } catch (e) {
                    Alert::error('Файл не найден: ' . $imagePath);
                }
            }
        }

        Alert::success('Товар успешно обновлен');
    }

    public function create(Request $request){
        $productData = $request->except('_token');

        $volume = (float) $productData['volume'];
        if ($volume < 0 || $volume > 99.999) {
            Alert::error('Товар не был сохранен. Проверьте введенные данные');
            return;
        }

        $product = Product::create($productData);

        $photoIds = $request->input('images');
        if (is_array($photoIds)) {
            foreach ($photoIds as $photoId) {
                $attachment = Attachment::find($photoId);

                if ($attachment) {
                    $productImage = new ProductImage([
                        'product_id' => $product->id,
                        'image_name' => $attachment->name,
                        'image_path' => $attachment->path,
                        'extension' => $attachment->extension,
                        'priority' => 0,
                    ]);

                    $imagePath = 'product_photos/' . $attachment->path . $attachment->name . '.' . $attachment->extension;

                    $img = Images::make($imagePath);
                    $img->fit(270, 370);
                    $img->save($imagePath);

                    $productImage->save();
                }
            }
        }
        Alert::success('Товар успешно добавлен');
    }

    public function delete(Request $request){
        $productId = $request->input('product');
        $product = Product::find($productId);

        if ($product) {
            $product->delete();
            Alert::success('Продукт успешно удален');
        }
        else Alert::error('Продукт не удален, возникла ошибка');
    }
}
