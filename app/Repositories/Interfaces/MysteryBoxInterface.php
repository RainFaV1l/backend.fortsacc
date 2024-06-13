<?php

namespace App\Repositories\Interfaces;

interface MysteryBoxInterface
{
    public function fakerSchedule() : void;
    public function getFakerWinners(): \Illuminate\Database\Eloquent\Collection;
}
