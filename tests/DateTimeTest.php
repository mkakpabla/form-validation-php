<?php


namespace Tests;

use PHPUnit\Framework\TestCase;
use Zen\Validation\Validator;

class DateTimeTest extends TestCase
{

    public function testDateTime()
    {
        $validator = new Validator([
            'date' => '2012-12-12'
        ], [
            'date' => 'datetime'
        ]);
        $validator->validate();
        $this->assertContains('Le champ date doit être une date valide', $validator->errors());
    }
}
