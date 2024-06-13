<?php

namespace App\Jobs;

use App\Repositories\Interfaces\MysteryBoxInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GetFakeWinnerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected MysteryBoxInterface $mysteryBoxRepository;

    /**
     * Create a new job instance.
     */
    public function __construct(MysteryBoxInterface $mysteryBoxRepository)
    {
        $this->mysteryBoxRepository = $mysteryBoxRepository;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->mysteryBoxRepository->fakerSchedule();
    }
}
