<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\RelatedNews;

use MoonShine\Fields\Date;
use MoonShine\Fields\DateRange;
use MoonShine\Fields\Relationships\BelongsTo;
use MoonShine\Fields\Text;
use MoonShine\Resources\ModelResource;
use MoonShine\Fields\ID;

/**
 * @extends ModelResource<RelatedNews>
 */
class RelatedNewsResource extends ModelResource
{
    protected string $model = RelatedNews::class;

    protected string $title = 'Связанные новости';

    public function indexFields(): array
    {
        return [
            ID::make()->sortable(),
            BelongsTo::make('Новость', 'news', resource: new NewsResource())->searchable()->sortable(),
            BelongsTo::make('Связанная новость', 'relatedNews', resource: new NewsResource())->searchable()->sortable(),
            Text::make('Дата изменения', 'updated_at')->sortable()->showOnExport(),
            Text::make('Дата создания', 'created_at')->sortable()->showOnExport(),
        ];
    }

    public function formFields(): array
    {
        return [
            ID::make()->sortable(),
            BelongsTo::make('Новость', 'news', resource: new NewsResource())->searchable()->sortable(),
            BelongsTo::make('Связанная новость', 'relatedNews', resource: new NewsResource())->searchable()->sortable(),
        ];
    }

    public function detailFields(): array
    {
        return [
            ID::make()->sortable(),
            BelongsTo::make('Новость', 'news', resource: new NewsResource())->searchable()->sortable(),
            BelongsTo::make('Связанная новость', 'relatedNews', resource: new NewsResource())->searchable()->sortable(),
            Text::make('Дата изменения', 'updated_at')->sortable()->showOnExport(),
            Text::make('Дата создания', 'created_at')->sortable()->showOnExport(),
        ];
    }

    public function rules(Model $item): array
    {
        return [
            'news_id' => 'required|integer|exists:news,id',
            'related_news_id' => 'required|integer|exists:news,id',
        ];
    }

    public function filters(): array
    {
        return [

            BelongsTo::make('Новость', 'news', resource: new NewsResource())->nullable()->searchable()->sortable(),

            BelongsTo::make('Связанная новость', 'relatedNews', resource: new NewsResource())->nullable()->searchable()->sortable(),

            DateRange::make('Дата изменения', 'updated_at')->nullable(),

            Date::make('Дата создания', 'created_at')->nullable(),

        ];
    }
}
