<?php

declare(strict_types=1);

namespace App\MoonShine\Pages;

use App\Models\Cart;
use App\Models\MysteryBox;
use App\Models\MysteryBoxParticipant;
use App\Models\Order;
use App\Models\PopularProduct;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\User;
use MoonShine\Decorations\Block;
use MoonShine\Decorations\Column;
use MoonShine\Decorations\Divider;
use MoonShine\Decorations\Flex;
use MoonShine\Decorations\Grid;
use MoonShine\Metrics\LineChartMetric;
use MoonShine\Metrics\ValueMetric;
use MoonShine\Pages\Page;

class Dashboard extends Page
{
    public function breadcrumbs(): array
    {
        return [
            '#' => $this->title()
        ];
    }

    public function title(): string
    {
        return $this->title ?: 'Панель администратора';
    }

    public function components(): array
	{
		return [
            Grid::make([
               Column::make([
                   Block::make([
                       LineChartMetric::make('Заказы')
                           ->line([
                               'Profit' => Cart::query()
                                   ->selectRaw('SUM(total) as sum, DATE_FORMAT(created_at, "%d.%m.%Y") as date')
                                   ->groupBy('date')
                                   ->pluck('total','date')
                                   ->toArray(),
                               'Avg' => Cart::query()
                                   ->selectRaw('AVG(total) as avg, DATE_FORMAT(created_at, "%d.%m.%Y") as date')
                                   ->groupBy('date')
                                   ->pluck('total','date')
                                   ->toArray()
                           ],[
                               'red', 'blue'
                           ]),
                   ]),
               ]),
                Column::make([
                    Flex::make([
                        ValueMetric::make('Продукты')
                            ->value(Product::query()->count()),
                        ValueMetric::make('Категории')
                            ->value(ProductCategory::query()->count()),
                        ValueMetric::make('Популярные')
                            ->value(PopularProduct::query()->count()),
                        ValueMetric::make('Пользователи')
                            ->value(User::query()->count()),
                        ValueMetric::make('Розыгрыши')
                            ->value(MysteryBox::query()->count()),
                        ValueMetric::make('Участники')
                            ->value(MysteryBoxParticipant::query()->count()),
                    ])->justifyAlign('start'),
                ])
            ]),
        ];
	}
}
