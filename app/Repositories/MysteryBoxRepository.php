<?php

namespace App\Repositories;

use App\Models\MysteryBoxFake;
use App\Repositories\Interfaces\MysteryBoxInterface;

class MysteryBoxRepository implements MysteryBoxInterface
{
    public function fakerSchedule(): void
    {
        MysteryBoxFake::query()->create([
            'nickname' => fake()->unique()->userName()
        ]);
    }

    public function getFakerWinners(): \Illuminate\Database\Eloquent\Collection
    {
        return MysteryBoxFake::all();
    }
}
