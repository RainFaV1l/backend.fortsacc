<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\News;

use App\MoonShine\Resources\NewsCategoryResource;
use MoonShine\Fields\ID;
use MoonShine\Fields\Image;
use MoonShine\Fields\Number;
use MoonShine\Fields\Relationships\BelongsTo;
use MoonShine\Fields\Switcher;
use MoonShine\Fields\Text;
use MoonShine\Fields\TinyMce;
use MoonShine\Pages\Crud\FormPage;

class NewsFormPage extends FormPage
{
    public function fields(): array
    {
        return [
            ID::make()->sortable(),
            TinyMce::make('Название', 'name')->sortable()->required(),
            TinyMce::make('Описание', 'description')->required(),
            Switcher::make('Опубликован', 'isPublished'),
            Number::make('Время чтения', 'reading_time')->sortable()->nullable()->showOnExport(),
            Image::make('Изображение', 'path')->dir('news')->disk('public'),
            BelongsTo::make('Категория', 'category', resource: new NewsCategoryResource())->required()->searchable()->showOnExport()
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
