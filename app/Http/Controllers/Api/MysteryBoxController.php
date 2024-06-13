<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FakeWinnerResource;
use App\Models\MysteryBox;
use App\Models\MysteryBoxParticipant;
use App\Repositories\Interfaces\MysteryBoxInterface;

class MysteryBoxController extends Controller
{
    private MysteryBoxInterface $mysteryBoxRepository;

    public function __construct(MysteryBoxInterface $mysteryBoxRepository)
    {
        $this->mysteryBoxRepository = $mysteryBoxRepository;
    }

    public function getWinners()
    {
        return FakeWinnerResource::collection($this->mysteryBoxRepository->getFakerWinners());
    }

    public function subscribe()
    {
        if(auth('sanctum')->user()) {

            $mysteryBox = MysteryBox::query()->latest()->first();

            if(empty($mysteryBox)) {

                $mysteryBox = MysteryBox::query()->create([
                    'name' => 'Test',
                    'description' => 'Test',
                ]);

            }

            $participant = MysteryBoxParticipant::query()
                ->where('mystery_boxes_id', $mysteryBox->id)
                ->where('participant_id', auth('sanctum')->user()->id)
                ->first();

            if(!empty($participant)) return response(["message" => "You are already participating in the draw"], 400);

            MysteryBoxParticipant::query()->create([
                'mystery_boxes_id' => $mysteryBox->id,
                'participant_id' => auth('sanctum')->user()->id,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Congratulations! You are participating in the draw',
            ]);

        }
    }
}
