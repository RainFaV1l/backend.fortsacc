<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\MysteryBoxParticipant;

use MoonShine\Fields\Date;
use MoonShine\Fields\DateRange;
use MoonShine\Fields\Number;
use MoonShine\Fields\Relationships\BelongsTo;
use MoonShine\Fields\Text;
use MoonShine\Resources\ModelResource;
use MoonShine\Fields\ID;

/**
 * @extends ModelResource<MysteryBoxParticipant>
 */
class MysteryBoxParticipantResource extends ModelResource
{
    protected string $model = MysteryBoxParticipant::class;

    protected string $title = 'Участники';

    public function indexFields(): array
    {
        return [
            ID::make()->sortable()->showOnExport(),
            BelongsTo::make('Участник', 'participant', resource: new UserResource())->searchable()->showOnExport(),
            BelongsTo::make('Розыгрыш', 'mysteryBox', resource: new MysteryBoxResource())->searchable()->showOnExport(),
            Text::make('Дата изменения', 'updated_at')->sortable()->showOnExport()->showOnExport(),
            Text::make('Дата создания', 'created_at')->sortable()->showOnExport()->showOnExport(),
        ];
    }

    public function formFields(): array
    {
        return [
            ID::make()->sortable(),
            BelongsTo::make('Участник', 'participant', resource: new UserResource())->searchable()->showOnExport(),
            BelongsTo::make('Розыгрыш', 'mysteryBox', resource: new MysteryBoxResource())->searchable()->showOnExport(),
        ];
    }

    public function detailFields(): array
    {
        return [
            ID::make()->sortable(),
            BelongsTo::make('Участник', 'participant', resource: new UserResource())->searchable()->showOnExport(),
            BelongsTo::make('Розыгрыш', 'mysteryBox', resource: new MysteryBoxResource())->searchable()->showOnExport(),
            Text::make('Дата изменения', 'updated_at')->sortable()->showOnExport()->showOnExport(),
            Text::make('Дата создания', 'created_at')->sortable()->showOnExport()->showOnExport(),
        ];
    }

    public function rules(Model $item): array
    {
        return [
            'participant_id' => 'required|int|exists:users,id',
            'mystery_boxes_id' => 'required|int|exists:mystery_boxes,id',
        ];
    }

    public function filters(): array
    {
        return [

            BelongsTo::make('Участник', 'participant', resource: new UserResource())->nullable()->searchable(),

            BelongsTo::make('Розыгрыш', 'mysteryBox', resource: new MysteryBoxResource())->nullable()->searchable(),

            DateRange::make('Дата создания', 'created_at')->nullable(),

            Date::make('Дата создания', 'created_at')->nullable(),

        ];
    }
}
