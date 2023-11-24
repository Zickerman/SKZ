<?php

namespace App\Orchid\Layouts\skz;

use App\Models\Article;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ArticlesTable extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'articles';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('title', 'Название')->cantHide()->sort()->width('200px')->cutString(65),
            TD::make('content', 'Новость/Статья')->width('350px')->cutString(185),
            TD::make('priority', 'Приоритет')->align('center')->popover('Чем выше значение, тем выше новость в списке по отношению к другим'),
            TD::make('created_at', 'Дата создания')->sort()->render(function (Article $article){
                return $article->created_at->format('d.m.Y');}),
            TD::make('updated_at', 'Дата изменения')->sort()->render(function (Article $article){
                return $article->updated_at->format('d.m.Y');}),
            TD::make('action', 'Редактировать')->render(function (Article $article){
                return ModalToggle::make('Изменить')->modal('editArticle')->method('update')
                    ->modalTitle('Редактирование новости' . $article->name)
                    ->asyncParameters([
                        'article' => $article->id
                    ]);
            }),
            TD::make('delete', 'Удалить')->render(function (Article $articles) {
                return Button::make('Удалить')->icon('trash')
                    ->confirm("<span style='color: #ff0000'>После подтверждения новость будет удалена из базы данных!</span>")
                    ->method('delete')
                    ->parameters(['articles' => $articles->id]);
            }),

        ];
    }
}
