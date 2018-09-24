<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Game;

class PlayGame extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'play:game
                            {frames}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Play ten-pin bowling game.
                                Input to the game should be array of arrays
                                Eg: [[5,2],[8,1],[6,4],[10],[0,5],[2,6],[8,1],[5,3],[6,1],[10,2,6]]';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try
        {
            $this->info('Starting Ten Pin Bowling Game');

            $frames = $this->argument('frames');
            $frames = json_decode($frames);

            $score = (new Game)->play($frames);
            $this->info('Output score of the game ');
            $this->info(json_encode($score, JSON_PRETTY_PRINT));
        }
        catch(\Exception $e)
        {
            $this->error('Error : '. $e->getMessage());

        }
    }
}
