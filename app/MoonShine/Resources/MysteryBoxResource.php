<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\MysteryBox;

use MoonShine\Fields\Date;
use MoonShine\Fields\DateRange;
use MoonShine\Fields\Relationships\BelongsTo;
use MoonShine\Fields\Text;
use MoonShine\Fields\TinyMce;
use MoonShine\Resources\ModelResource;
use MoonShine\Fields\ID;

/**
 * @extends ModelResource<MysteryBox>
 */
class MysteryBoxResource extends ModelResource
{
    protected string $model = MysteryBox::class;

    protected string $title = 'Розыгрыш';

    public function indexFields(): array
    {
        return [
            ID::make()->sortable(),
            Text::make('Название', 'name'),
            TinyMce::make('Описание', 'description'),
            BelongsTo::make('Победитель', 'winner', resource: new UserResource())->searchable()->showOnExport(),
            Text::make('Дата окончания', 'expired_at')->sortable()->showOnExport()->showOnExport(),
            Text::make('Дата изменения', 'updated_at')->sortable()->showOnExport()->showOnExport(),
            Text::make('Дата создания', 'created_at')->sortable()->showOnExport()->showOnExport(),
        ];
    }

    public function formFields(): array
    {
        return [
            ID::make()->sortable(),
            Text::make('Название', 'name'),
            TinyMce::make('Описание', 'description'),
            BelongsTo::make('Победитель', 'winner', resource: new UserResource())->searchable()->showOnExport(),
            Text::make('Дата окончания', 'expired_at')->sortable()->showOnExport()->showOnExport(),
        ];
    }

    public function detailFields(): array
    {
        return [
            ID::make()->sortable(),
            Text::make('Название', 'name'),
            TinyMce::make('Описание', 'description'),
            BelongsTo::make('Победитель', 'winner', resource: new UserResource())->searchable()->showOnExport(),
            Text::make('Дата окончания', 'expired_at')->sortable()->showOnExport()->showOnExport(),
            Text::make('Дата изменения', 'updated_at')->sortable()->showOnExport()->showOnExport(),
            Text::make('Дата создания', 'created_at')->sortable()->showOnExport()->showOnExport(),
        ];
    }

    public function rules(Model $item): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:5000',
            'winner_id' => 'required|int|exists:users,id',
            'expired_at' => 'required|date',
        ];
    }

    public function filters(): array
    {
        return [

            Text::make('Название', 'name'),

            TinyMce::make('Описание', 'description'),

            BelongsTo::make('Победитель', 'winner', resource: new UserResource())->searchable()->nullable(),

            Text::make('Дата окончания', 'expired_at')->sortable()->showOnExport(),

            DateRange::make('Дата создания', 'created_at')->nullable(),

            Date::make('Дата создания', 'created_at')->nullable(),

        ];
    }
}
