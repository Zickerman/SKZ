<?php

namespace App\Orchid\Screens\skz;

use App\Orchid\Layouts\skz\ArticlesTable;
use Orchid\Screen\Screen;
use App\Models\Article;
use Illuminate\Http\Request;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Upload;
use Orchid\Attachment\Models\Attachment;
use App\Models\ArticleImage;
use Intervention\Image\ImageManagerStatic as Images;

class ArticlesScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'articles' => Article::all(),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Новости';
    }

    public function description(): ?string
    {
        return "Здесь вы можете добавить, изменить или удалить новость в/из БД.";
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('Добавить')->modal('createArticles')->method('create'),

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
            ArticlesTable::class,
            Layout::modal('createArticles', Layout::rows([
                Input::make('title')->required()->title('Название')->type('text'),
                TextArea::make('content')->required()->title('Содержание')->rows(15)->type('text'),
                Input::make('priority')->title('Приоритет')->type('number')->max(100)->popover('Максимальный приоритет 100'),
                Upload::make('images')->title('Фотографии новости')->multiple()->acceptedFiles('image/*')
                    ->maxFiles(5)->groups('photo')->hint('Вы можете загрузить до 5 фотографий.')->storage('article_photos'),
            ]))->title('Добавить новость')->applyButton('Создать'),

            Layout::modal('editArticle', Layout::rows([
                Input::make('article.id')->type('hidden'),
                Input::make('article.title')->required()->title('Название новости')->type('text'),
                TextArea::make('article.content')->required()->title('Содержание')->rows(15)->type('text'),
                Input::make('article.priority')->title('Приоритет')->type('number')->max(100)->popover('Максимальный приоритет 100'),
                Upload::make('images')->title('Фотографии новости')->multiple()->acceptedFiles('image/*')
                    ->maxFiles(5)->groups('photo')->hint('Вы можете загрузить до 5 фотографий.')->storage('article_photos'),
            ]))->async('asyncGetArticle'),


        ];
    }

    public function asyncGetArticle(Article $article){
        return [
            'article' => $article,
        ];
    }

    public function update(Request $request) {
        $articleId = $request->input('article.id');
        $article = Article::find($articleId);

        if (!$article) {
            Alert::error('Новость не найдена');
            return;
        }
        $article->update($request->article);

        $newPhotoIds = $request->input('images');

        if (is_array($newPhotoIds)) {
            foreach ($newPhotoIds as $newPhotoId) {
                try {
                    $attachment = Attachment::findOrFail($newPhotoId);
                    $imagePath = 'article_photos/' . $attachment->path . $attachment->name . '.' . $attachment->extension;

                    $img = Images::make($imagePath);
                    $img->fit(270, 370);
                    $img->save($imagePath);

                    $articleImage = ArticleImage::where('article_id', $article->id)
                        ->update([
                            'image_name' => $attachment->name,
                            'image_path' => $attachment->path,
                            'extension' => $attachment->extension,
                            'priority' => $article->priority,
                        ]);

                    if (!$articleImage) {
                        $articleImage = new ArticleImage([
                            'article_id' => $article->id,
                            'image_name' => $attachment->name,
                            'image_path' => $attachment->path,
                            'extension' => $attachment->extension,
                            'priority' => $article->priority,
                        ]);

                        $articleImage->save();
                    }

                } catch (e) {
                    Alert::error('Файл не найден: ' . $imagePath);
                }
            }
        }

        Alert::success('Новость успешно обновлена');
    }

    public function create(Request $request){
        $articleData = $request->except('_token');

        $article = Article::create($articleData);

        $photoIds = $request->input('images');
        if (is_array($photoIds)) {
            foreach ($photoIds as $photoId) {
                $attachment = Attachment::find($photoId);

                if ($attachment) {
                    $articleImage = new ArticleImage([
                        'article_id' => $article->id,
                        'image_name' => $attachment->name,
                        'image_path' => $attachment->path,
                        'extension' => $attachment->extension,
                        'priority' => $article->priority,
                    ]);

                    $imagePath = 'article_photos/' . $attachment->path . $attachment->name . '.' . $attachment->extension;

                    $img = Images::make($imagePath);
                    $img->fit(270, 370);
                    $img->save($imagePath);


                    $articleImage->save();
                }
            }
        }
        Alert::success('Новость успешно создана');
    }

    public function delete(Request $request){
        $articlesId = $request->input('articles');
        $articles = Article::find($articlesId);

        if ($articles) {
            $articles->delete();
            Alert::success('Новость успешно удалена');
        }
        else Alert::error('Новость не удалена, возникла ошибка');
    }
}
