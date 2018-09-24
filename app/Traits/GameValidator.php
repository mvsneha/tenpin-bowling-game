<?php

namespace App\Traits;

use App\Game;

trait GameValidator
{
    /**
     * Validate Entire Frame
     * @param  $frames
     * @return void
     */
    public function validateFrames($frames): void
    {
        $this->isFrameArray($frames);

        $this->isFrameCountTen($frames, Game::TOTAL_FRAMES);

        $i = 0;

        foreach($frames as $frame)
        {
            if($i == Game::TOTAL_FRAMES -1) // last frame
            {
                $this->checkLastFrameValidty($frame);
            }
            else
            {
                $this->checkFrameValidty($frame);

                $this->checkStrikeFrameValue($frame);
            }

            foreach($frame as $pins)
            {
                $this->checkPinValue($pins);
            }

            $i++;
        }
    }

    /**
     * @param  array
     * @param  int
     * @return void
     */
    public function isFrameCountTen(array $frames, int $total_frames): void
    {
        if(count($frames) != $total_frames)
            throw new \InvalidArgumentException($total_frames.' frames are required');
    }

    /**
     * @param  frames
     * @return void
     */
    public function isFrameArray($frames): void
    {
        if(is_array($frames) === false)
            throw new \InvalidArgumentException('Frames should be array');

        foreach($frames as $frame)
        {
            if(is_array($frame) === false)
                throw new \InvalidArgumentException('Sub frame should be an array');
        }
    }

    /**
     * @param  $pin
     * @return void
     */
    public function checkPinValue($pin): void
    {
        if(is_int($pin) === false || $pin < 0 || $pin > 10)
            throw new \InvalidArgumentException('Pin value should be an integer between 0 and 10');
    }

    /**
     * @param  array
     * @return void
     */
    public function checkFrameValidty(array $frame): void
    {
        if(array_sum($frame) > 10)
            throw new \InvalidArgumentException('Frame pins count cannot exceed 10');

        if(count($frame) > 2)
            throw new \InvalidArgumentException('Each frame expect maximum 2 throws');
    }

    /**
     * @param  array
     * @return void
     */
    public function checkLastFrameValidty(array $frame): void
    {
        if(count($frame) != 3)
            throw new \InvalidArgumentException('Last frame expect 3 throws');
    }

    /**
     * @param  array
     * @return void
     */
    public function checkStrikeFrameValue(array $frame): void
    {
        if(count($frame) === 1 && current($frame) !== 10)
            throw new \InvalidArgumentException('Strike throw can have 10pins');

    }
}
