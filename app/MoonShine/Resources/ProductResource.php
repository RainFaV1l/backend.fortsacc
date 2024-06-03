<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

use MoonShine\Fields\Image;
use MoonShine\Fields\Number;
use MoonShine\Fields\Relationships\BelongsTo;
use MoonShine\Fields\Switcher;
use MoonShine\Fields\Text;
use MoonShine\Fields\TinyMce;
use MoonShine\Resources\ModelResource;
use MoonShine\Decorations\Block;
use MoonShine\Fields\Date;
use MoonShine\Fields\DateRange;
use MoonShine\Fields\ID;
use MoonShine\Fields\RangeSlider;

class ProductResource extends ModelResource
{
    protected string $model = Product::class;

    protected string $title = 'Продукты';

//    protected array $with = ['category']; // Eager load

    protected string $sortColumn = 'id'; // Поле сортировки по умолчанию

    protected string $sortDirection = 'DESC'; // Тип сортировки по умолчанию

    protected int $itemsPerPage = 15; // Количество элементов на странице

    public string $column = 'name'; // Поле для отображения значений в связях и хлебных крошках

    protected bool $saveFilterState = true;

    public function fields(): array
    {
        return [
            Block::make([
                ID::make()->sortable()->showOnExport(),
                Text::make('Название', 'name')->showOnExport(),
                Text::make('Краткое описание', 'short_description')->showOnExport()->hideOnIndex(),
                TinyMce::make('Описание', 'description')->showOnExport()->hideOnIndex(),
                Number::make('Количество', 'stock'),
                Text::make('Доставка', 'delivery'),
                Text::make('Игра', 'game'),
                Text::make('Почта', 'mail'),
                Number::make('Цена', 'price')->sortable()->showOnExport(),
                // Text::make('Валюта', 'currency')->sortable()->showOnExport(),
                Image::make('Превью', 'preview')->disk('local')->dir('/public/products')->showOnExport(),
                BelongsTo::make('Категория', 'category', resource: new ProductCategoryResource())->required()->searchable()->showOnExport(),
                Text::make('Дата изменения', 'updated_at')->sortable()->showOnExport()->hideOnForm()->hideOnIndex(),
                Text::make('Дата создания', 'created_at')->sortable()->showOnExport()->hideOnForm()->hideOnIndex(),
                Switcher::make('Популярно', 'popular')
            ]),
        ];
    }

    public function rules(Model $item): array
    {
        return [
            'name' => 'required|string|max:255',
            'short_description' => 'required|string|max:500',
            'description' => 'required|string|max:2000',
            'stock' => 'nullable|int|max:1000000',
            'delivery' => 'nullable|string|max:255',
            'game' => 'nullable|string|max:255',
            'mail' => 'nullable|string|max:255',
            'price' => 'required|numeric|max:1000000',
            'preview' => 'nullable|image',
        ];
    }

    public function filters(): array
    {
        return [
            Text::make('Название', 'name')->nullable(),

            BelongsTo::make('Категория', 'category', resource: new ProductCategoryResource())->searchable()->nullable(),

            DateRange::make('Дата создания', 'created_at')->nullable(),

            Date::make('Дата создания', 'created_at')->nullable(),

            RangeSlider::make('Цена', 'price')
                ->min(0)
                ->max(1000000)->nullable(),
        ];
    }
}
