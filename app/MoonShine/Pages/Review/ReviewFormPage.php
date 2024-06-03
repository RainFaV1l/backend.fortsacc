<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\Review;

use App\MoonShine\Resources\UserResource;
use MoonShine\Fields\ID;
use MoonShine\Fields\Relationships\BelongsTo;
use MoonShine\Fields\Switcher;
use MoonShine\Fields\Text;
use MoonShine\Fields\TinyMce;
use MoonShine\Pages\Crud\FormPage;

class ReviewFormPage extends FormPage
{
    public function fields(): array
    {
        return [
            ID::make()->sortable()->showOnExport(),
            BelongsTo::make('Пользователь', 'user', resource: new UserResource())->nullable()->searchable()->showOnExport(),
            Text::make('Полное имя', 'full_name')->sortable()->required()->showOnExport(),
            TinyMce::make('Отзыв', 'message')->required()->showOnExport(),
            Switcher::make('Публикация', 'isPublished')->showOnExport(),
        ];
    }

    protected function topLayer(): array
    {
        return [
            ...parent::topLayer()
        ];
    }

    protected function mainLayer(): array
    {
        return [
            ...parent::mainLayer()
        ];
    }

    protected function bottomLayer(): array
    {
        return [
            ...parent::bottomLayer()
        ];
    }
}
