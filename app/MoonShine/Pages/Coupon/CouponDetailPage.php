<?php

declare(strict_types=1);

namespace App\MoonShine\Pages\Coupon;

use MoonShine\Fields\Date;
use MoonShine\Fields\ID;
use MoonShine\Fields\Number;
use MoonShine\Fields\Text;
use MoonShine\Pages\Crud\DetailPage;

class CouponDetailPage extends DetailPage
{
    public function fields(): array
    {
        return [
            ID::make()->sortable(),
            Text::make('Название купона', 'name'),
            Number::make('Процент скидки', 'percent'),
            Date::make('Дата истечения', 'expired_at'),
            Date::make('Дата обновления', 'updated_at'),
            Date::make('Дата создания', 'created_at')
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
