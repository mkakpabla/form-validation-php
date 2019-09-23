<?php


namespace Tests;

use PHPUnit\Framework\TestCase;
use Zen\Validation\Validator;

class MaxTest extends TestCase
{


    public function testMaxIsFaill()
    {
        $validator = new Validator([
            'content' => 'ddddddddddddd'
        ], [
            'content' => 'max:5'
        ]);
        $validator->validate();
        $this->assertContains('Le champ content doit contenir moins de 5 caractères', $validator->errors());
        $this->assertEquals(false, $validator->isValid());
    }

    public function testMaxIsValid()
    {
        $validator = new Validator([
            'content' => 'michel'
        ], [
            'content' => 'max:6'
        ]);
        $validator->validate();
        $this->assertEquals(true, $validator->isValid());
    }
}
