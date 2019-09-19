<?php


namespace Tests;

use PHPUnit\Framework\TestCase;
use Zen\Validation\Validator;

class TimeTest extends TestCase
{


    public function testTime()
    {
        $validator = new Validator([
            'date' => '2012-12-12'
        ], [
            'date' => 'time'
        ]);
        $validator->validate();
        $this->assertContains('Le champ date doit être une heur valide', $validator->errors());
    }
}