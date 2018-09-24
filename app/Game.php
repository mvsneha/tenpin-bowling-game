<?php

namespace App;

use App\Traits\GameValidator;

class Game
{
    use GameValidator;

    const TOTAL_FRAMES = 10;

    protected $rolls = [];

    /**
     * Validate the game and calculate the score
     * @param  $frames
     * @return array
     */
    public function play($frames)
    {
        $this->validateFrames($frames);
        $this->rolls = array_collapse($frames);
        return $this->score();
    }

    /**
     * Added for testing, need to refactor it
     * @param  int
     *
     */
    public function roll($pin)
    {
        $this->checkPinValue($pin);

        $this->rolls[] = $pin;
    }

    /**
     * Calculate the score
     * @return array
     */
    public function score(): array
    {
        $score = 0;
        $roll = 0;
        $frame_score = [];

        for($frame = 1; $frame <= self::TOTAL_FRAMES; $frame++)
        {
            if($this->isStrike($roll))
            {
                $score += 10 + $this->strikeBonus($roll);
                $roll += 1;
            }
            else
            {
                $score += $this->getDefaultFrameScore($roll);
                $roll += 2;
            }

            $frame_score[$frame] = $score;
        }

        return $frame_score;
    }

    /**
     * @param  array
     * @return boolean
     */
    private function isStrike($roll): bool
    {
        return $this->rolls[$roll] == 10;
    }

    /**
     * @param  int
     * @return int
     */
    private function strikeBonus($roll): int
    {
        return $this->rolls[$roll + 1] + $this->rolls[$roll + 2];
    }

    /**
     * @param  int
     * @return int
     */
    private function getDefaultFrameScore($roll): int
    {
        return $this->rolls[$roll] + $this->rolls[$roll + 1];
    }
}
