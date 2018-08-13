<?php

namespace Tests\Unit;

use App\Package\TextCorrector;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TextCorrectorTest extends TestCase
{
    public function testCorrectTextFromCapsToSmall()
    {
        $textFrom = 'HELLO WORLD';
        $textTo = 'hello world';

        $textOutput = app()->make(TextCorrector::class)->capsLock($textFrom);

        $this->assertTrue($textTo === $textOutput);
    }
    public function testCorrectTextKeyTranslate()
    {
        $textFrom = 'ghbdtn vbh';
        $textTo = 'привет мир';

        $textOutput = app()->make(TextCorrector::class)->punto($textFrom);

        $this->assertTrue($textTo === $textOutput);
    }
}
