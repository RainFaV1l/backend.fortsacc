<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Review;
use App\MoonShine\Pages\Review\ReviewIndexPage;
use App\MoonShine\Pages\Review\ReviewFormPage;
use App\MoonShine\Pages\Review\ReviewDetailPage;

use MoonShine\Fields\Date;
use MoonShine\Fields\DateRange;
use MoonShine\Fields\ID;
use MoonShine\Fields\Image;
use MoonShine\Fields\Relationships\BelongsTo;
use MoonShine\Fields\Switcher;
use MoonShine\Fields\Text;
use MoonShine\Fields\TinyMce;
use MoonShine\Resources\ModelResource;

/**
 * @extends ModelResource<Review>
 */
class ReviewResource extends ModelResource
{
    protected string $model = Review::class;

    protected string $title = 'Отзывы';

    public function pages(): array
    {
        return [
            ReviewIndexPage::make($this->title()),
            ReviewFormPage::make(
                $this->getItemID()
                    ? __('moonshine::ui.edit')
                    : __('moonshine::ui.add')
            ),
            ReviewDetailPage::make(__('moonshine::ui.show')),
        ];
    }

    public function rules(Model $item): array
    {
        return [
            'user_id' => 'nullable|integer|exists:users,id',
            'full_name' => 'required|string|max:500',
            'message' => 'required|string|max:2000',
            'isPublished' => 'nullable|boolean',
        ];
    }

    public function fields(): array
    {
        return [
            ID::make()->sortable()->showOnExport(),
            BelongsTo::make('Пользователь', 'user', resource: new UserResource())->required()->searchable()->showOnExport(),
            Text::make('Полное имя', 'full_name')->sortable()->required()->showOnExport(),
            TinyMce::make('Отзыв', 'message')->required()->showOnExport(),
            Switcher::make('Публикация', 'isPublished')->required()->showOnExport(),
        ];
    }

    public function search(): array
    {
        return [
            'full_name', 'message'
        ];
    }

    public function filters(): array
    {
        return [
            BelongsTo::make('Пользователь', 'user', resource: new UserResource())->required()->searchable()->showOnExport(),

            DateRange::make('Дата отправки', 'created_at')->nullable(),
        ];
    }
}
