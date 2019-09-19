<?php


namespace Tests;

use PHPUnit\Framework\TestCase;
use Zen\Validation\Validator;

class IntegerTest extends TestCase
{

    public function testInteger()
    {
        $data = [
            'author' => 'Michel',
            'title' => 'Michel',
            'price' => 'toto'
        ];
        $validator = new Validator($data, [
            'title'  => 'required|notEmpty|alpha',
            'author' => 'required|notEmpty',
            'price' => 'required|notEmpty|integer'
        ]);
        $validator->validate();
        $this->assertContains('le price doit être un entier(Ex: 1234)', $validator->errors());
        $this->assertEquals(false, $validator->isValid());
    }
}
