<?php

namespace App\Orchid\Resources;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Eloquent\Model;
use Orchid\Crud\Resource;
use Orchid\Platform\Models\User;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Sight;
use Orchid\Screen\TD;

class PostResource extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Post::class;

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            Input::make('title')->title('Title')->placeholder('Enter title here'),
            Quill::make('content')->title('Post Content')->placeholder('Once upon a time...'),
            Relation::make('user_id')->title('Author')->fromModel(User::class, 'name', 'id')->empty('No select'),
            Relation::make('category_id')->title('Category')->fromModel(Category::class, 'name', 'id')->empty('No select')
        ];
    }

    /**
     * Get the columns displayed by the resource.
     *
     * @return TD[]
     */
    public function columns(): array
    {
        return [
            TD::make()->render(function (Post $post){
            return CheckBox::make('posts[]')
                ->value($post->id)
                ->placeholder($post->title)
                ->checked(false);
            }),
            TD::make('id'),
            TD::make('title'),
            TD::make('authorName', title: 'Author'),
            TD::make('categoryName', title: 'Category'),
            TD::make('created_at', 'Date of creation')
                ->render(function ($model) {
                    return $model->created_at->toDateTimeString();
                }),

            TD::make('updated_at', 'Update date')
                ->render(function ($model) {
                    return $model->updated_at->toDateTimeString();
                }),
        ];
    }

    /**
     * Get the sights displayed by the resource.
     *
     * @return Sight[]
     */
    public function legend(): array
    {
        return [
            Sight::make('id'),
            Sight::make('title'),
            Sight::make('content'),
        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array
     */
    public function filters(): array
    {
        return [];
    }

    /**
     * Summary of rules
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return array
     */
    public function rules(Model $model): array
    {
        return [
            'title' => ['required'],
            'content' => ['required']
        ];
    }
}
