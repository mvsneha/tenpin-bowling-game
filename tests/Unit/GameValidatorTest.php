<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Game;
use App\Traits\GameValidator;
use InvalidArgumentException;

class GameValidatorTest extends TestCase
{
    use GameValidator;

    public function testInputFrameIsArray()
    {
        $input = [[5,2],[8,1],[6,4],[10],[0,5],[2,6],[8,1],[5,3],[6,1],[10,2,6]];
        $this->assertNull($this->isFrameArray($input));
    }

    public function testInputFrameNotArray()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->isFrameArray('5,2');
    }

    public function testInputSubFrameIsArray()
    {
        $input = [[5,2],[8,1],[6,4],[10],[0,5],[2,6],[8,1],[5,3],[6,1],[10,2,6]];
        $this->assertNull($this->isFrameArray($input));
    }

    public function testInputSubFrameNotArray()
    {
        $input = [[5,2],[8,1],[6,4],[10],[0,5],[2,6],[8,1],[5,3],[6,1],10];
        $this->expectException(InvalidArgumentException::class);
        $this->isFrameArray($input);
    }

    public function testTotalFramesIsTen()
    {
        $input = [[5,2],[8,1],[6,4],[10],[0,5],[2,6],[8,1],[5,3],[6,1],[10,2,6]];
        $this->assertNull($this->isFrameCountTen($input, Game::TOTAL_FRAMES));
    }

    public function testTotalFramesIsNotTen()
    {
        $input = [[5,2]];
        $this->expectException(InvalidArgumentException::class);
        $this->isFrameCountTen($input, Game::TOTAL_FRAMES);
    }

    public function testPinValue()
    {
        $input = 10;
        $this->assertNull($this->checkPinValue($input));
    }

    public function testPinValueInvalid()
    {
        $input = -1;
        $this->expectException(InvalidArgumentException::class);
        $this->checkPinValue($input);
    }

    public function testPinValueGreaterThan10()
    {
        $input = 11;
        $this->expectException(InvalidArgumentException::class);
        $this->checkPinValue($input);
    }

    public function testPinValueOtherThanInteger()
    {
        $input = [11];
        $this->expectException(InvalidArgumentException::class);
        $this->checkPinValue($input);
    }

    public function testStrikeFrameValue()
    {
        $input = [10];
        $this->assertNull($this->checkStrikeFrameValue($input));
    }

    public function testStrikeFrameValueInvalid()
    {
        $input = [11];
        $this->expectException(InvalidArgumentException::class);
        $this->checkStrikeFrameValue($input);
    }

    public function testFrameScoreNotGreaterThanTen()
    {
        $input = [6, 1];
        $this->assertNull($this->checkFrameValidty($input));
    }

    public function testFrameScoreGreaterThanTen()
    {
        $input = [6, 6];
        $this->expectException(InvalidArgumentException::class);
        $this->checkFrameValidty($input);
    }

    public function testFrameCountGreaterThanTwo()
    {
        $input = [6, 6, 2];
        $this->expectException(InvalidArgumentException::class);
        $this->checkFrameValidty($input);
    }

    public function testLastFrameCountNotGreaterThanThree()
    {
        $input = [6, 1, 2];
        $this->assertNull($this->checkLastFrameValidty($input));
    }

    public function testLastFrameCountGreaterThanThree()
    {
        $input = [6, 1, 2, 4];
        $this->expectException(InvalidArgumentException::class);
        $this->checkLastFrameValidty($input);
    }
}
