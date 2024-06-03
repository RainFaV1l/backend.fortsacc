<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\News;

use App\MoonShine\Resources\NewsCategoryResource;
use MoonShine\Fields\ID;
use MoonShine\Fields\Image;
use MoonShine\Fields\Relationships\BelongsTo;
use MoonShine\Fields\Switcher;
use MoonShine\Fields\Text;
use MoonShine\Fields\TinyMce;
use MoonShine\Pages\Crud\DetailPage;

class NewsDetailPage extends DetailPage
{
    public function fields(): array
    {
        return [
            ID::make()->sortable(),
            Text::make('Название', 'name')->sortable(),
            TinyMce::make('Описание', 'description'),
            Switcher::make('Опубликован', 'isPublished'),
            Image::make('Изображение', 'path')->dir('news')->disk('public'),
            BelongsTo::make('Категория', 'category', resource: new NewsCategoryResource())->required()->searchable()->showOnExport(),
            Text::make('Дата обновления', 'updated_at')->sortable(),
            Text::make('Дата создания', 'created_at')->sortable(),
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
