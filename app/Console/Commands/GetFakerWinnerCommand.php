<?php

namespace App\Console\Commands;

use App\Jobs\GetFakeWinnerJob;
use App\Repositories\Interfaces\MysteryBoxInterface;
use Illuminate\Console\Command;

class GetFakerWinnerCommand extends Command
{
    protected MysteryBoxInterface $mysteryBoxRepository;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mystery:fake';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function __construct(MysteryBoxInterface $mysteryBoxRepository)
    {
        parent::__construct();
        $this->mysteryBoxRepository = $mysteryBoxRepository;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        GetFakeWinnerJob::dispatch($this->mysteryBoxRepository);
    }
}
