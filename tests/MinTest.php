<?php


namespace Tests;

use PHPUnit\Framework\TestCase;
use Zen\Validation\Validator;

class MinTest extends TestCase
{


    public function testMinIsFaill()
    {
        $validator = new Validator([
            'content' => 'dd'
        ], [
            'content' => 'min:5'
        ]);
        $validator->validate();
        $this->assertContains('Le champ content doit contenir plus de 5 caractères', $validator->errors());
        $this->assertEquals(false, $validator->isValid());
    }

    public function testMinIsValid()
    {
        $validator = new Validator([
            'content' => 'michel'
        ], [
            'content' => 'min:5'
        ]);
        $validator->validate();
        $this->assertEquals(true, $validator->isValid());
    }
}
