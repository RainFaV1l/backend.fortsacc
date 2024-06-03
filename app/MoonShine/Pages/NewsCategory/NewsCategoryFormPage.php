<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\NewsCategory;

use MoonShine\Fields\ID;
use MoonShine\Fields\Text;
use MoonShine\Pages\Crud\FormPage;

class NewsCategoryFormPage extends FormPage
{
    public function fields(): array
    {
        return [
            ID::make()->sortable(),
            Text::make('Название', 'name')->sortable(),
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
