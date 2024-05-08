<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\Coupon;

use MoonShine\Fields\Date;
use MoonShine\Fields\ID;
use MoonShine\Fields\Number;
use MoonShine\Fields\Text;
use MoonShine\Pages\Crud\FormPage;

class CouponFormPage extends FormPage
{
    public function fields(): array
    {
        return [
            ID::make()->sortable(),
            Text::make('Название купона', 'name')->sortable(),
            Number::make('Процент скидки', 'percent')->max(100)->min(1)->buttons(),
            Date::make('Дата истечения', 'expired_at')->sortable()
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
