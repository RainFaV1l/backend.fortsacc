<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\NewsCategory;
use App\MoonShine\Pages\NewsCategory\NewsCategoryIndexPage;
use App\MoonShine\Pages\NewsCategory\NewsCategoryFormPage;
use App\MoonShine\Pages\NewsCategory\NewsCategoryDetailPage;

use MoonShine\Fields\Date;
use MoonShine\Fields\DateRange;
use MoonShine\Fields\ID;
use MoonShine\Fields\Relationships\BelongsTo;
use MoonShine\Fields\Text;
use MoonShine\Resources\ModelResource;

/**
 * @extends ModelResource<NewsCategory>
 */
class NewsCategoryResource extends ModelResource
{
    protected string $model = NewsCategory::class;

    protected string $title = 'Категории';

    protected int $itemsPerPage = 15; // Количество элементов на странице

    public string $column = 'name'; // Поле для отображения значений в связях и хлебных крошках

    protected bool $saveFilterState = true;

    protected string $sortColumn = 'id'; // Поле сортировки по умолчанию

    protected string $sortDirection = 'DESC'; // Тип сортировки по умолчанию

    protected bool $isAsync = true;

    public function fields(): array
    {
        return [
            ID::make()->sortable()->showOnExport(),
            Text::make('Название', 'name')->sortable()->showOnExport(),
        ];
    }

    public function pages(): array
    {
        return [
            NewsCategoryIndexPage::make($this->title()),
            NewsCategoryFormPage::make(
                $this->getItemID()
                    ? __('moonshine::ui.edit')
                    : __('moonshine::ui.add')
            ),
            NewsCategoryDetailPage::make(__('moonshine::ui.show')),
        ];
    }

    public function rules(Model $item): array
    {
        return [
            'name' => 'required|string|max:255',
        ];
    }

    public function search(): array
    {
        return ['name']; // TODO: Change the autogenerated stub
    }

    public function filters(): array
    {
        return [
            DateRange::make('Дата создания', 'created_at')->nullable(),

            Date::make('Дата создания', 'created_at')->nullable(),
        ];
    }
}