<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\News;
use App\MoonShine\Pages\News\NewsIndexPage;
use App\MoonShine\Pages\News\NewsFormPage;
use App\MoonShine\Pages\News\NewsDetailPage;

use MoonShine\Fields\Date;
use MoonShine\Fields\DateRange;
use MoonShine\Fields\ID;
use MoonShine\Fields\Image;
use MoonShine\Fields\Number;
use MoonShine\Fields\RangeSlider;
use MoonShine\Fields\Relationships\BelongsTo;
use MoonShine\Fields\Switcher;
use MoonShine\Fields\Text;
use MoonShine\Fields\TinyMce;
use MoonShine\Resources\ModelResource;

/**
 * @extends ModelResource<News>
 */
class NewsResource extends ModelResource
{
    protected string $model = News::class;

    protected string $title = 'Новости';

    protected array $with = ['category'];

    protected string $sortColumn = 'id'; // Поле сортировки по умолчанию

    protected string $sortDirection = 'DESC'; // Тип сортировки по умолчанию

    protected int $itemsPerPage = 15; // Количество элементов на странице

    public string $column = 'name'; // Поле для отображения значений в связях и хлебных крошках

    protected bool $saveFilterState = true;

    protected bool $isAsync = true;

    public function pages(): array
    {
        return [
            NewsIndexPage::make($this->title()),
            NewsFormPage::make(
                $this->getItemID()
                    ? __('moonshine::ui.edit')
                    : __('moonshine::ui.add')
            ),
            NewsDetailPage::make(__('moonshine::ui.show')),
        ];
    }

        public function rules(Model $item): array
        {
            return [
                'name' => 'required|string|max:255',
                'reading_time' => 'nullable|integer',
                'description' => 'required|string|nullable',
                'isPublished' => 'required|boolean',
                'path' => [$item->exists ? 'sometimes' : 'required', 'image'],
                'news_category_id' => 'required|integer|exists:news_categories,id',
            ];
        }

    public function fields(): array
    {
        return [
            ID::make()->sortable()->showOnExport(),
            TinyMce::make('Название', 'name')->sortable()->required()->showOnExport(),
            Text::make('Описание', 'description')->required()->showOnExport(),
            Number::make('Время чтения', 'reading_time')->nullable()->showOnExport(),
            Switcher::make('Опубликован', 'isPublished')->required()->showOnExport(),
            Image::make('Изображение', 'path')->dir('news')->disk('public'),
            BelongsTo::make('Категория', 'category', resource: new NewsCategoryResource())->required()->searchable()->showOnExport()
        ];
    }

    public function search(): array
    {
        return [
            'name', 'description'
        ];
    }

    public function filters(): array
    {
        return [
            BelongsTo::make('Категория', 'category', resource: new NewsCategoryResource())->searchable()->nullable(),

            Number::make('Время чтения', 'reading_time')->nullable()->showOnExport(),

            DateRange::make('Дата создания', 'created_at')->nullable(),

            Date::make('Дата создания', 'created_at')->nullable(),
        ];
    }
}
