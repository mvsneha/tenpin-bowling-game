<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Game;

class GameTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    function testGameWithAllZeroThrow()
    {
        $game = new Game();
        $this->rollTimes($game, 20, 0);
        $score = $game->score();

        $this->assertEquals(0, $score[10]);
    }

    function testGameWithAllOnePointInEachThrow()
    {
        $game = new Game();
        $this->rollTimes($game, 20, 1);
        $score = $game->score();
        $this->assertEquals(20, $score[10]);
    }

    function testGameWithAllOneStrike()
    {
        $game = new Game();
        $game->roll(10);
        $game->roll(5);
        $game->roll(5);
        $this->rollTimes($game, 17, 0);
        $score = $game->score();
        $this->assertEquals(30, $score[10]);
    }

    function testGameWithAllThreeconsecutiveStrike()
    {
        $game = new Game();
        $game->roll(10);
        $game->roll(10);
        $game->roll(10);
        $game->roll(6);
        $game->roll(0);
        $this->rollTimes($game, 15, 0);
        $score = $game->score();
        $this->assertEquals(78, $score[10]);
    }


    function testGameWithAllStrike()
    {
        $game = new Game();
        $this->rollTimes($game, 12, 10);
        $score = $game->score();
        $this->assertEquals(300, $score[10]);
    }

    private function rollTimes(Game $game, $count, $pins)
    {
        for ($i = 0; $i < $count; $i++)
        {
            $game->roll($pins);
        }
    }


}
