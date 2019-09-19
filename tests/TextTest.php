<?php


namespace Tests;

use PHPUnit\Framework\TestCase;
use Zen\Validation\Validator;

class TextTest extends TestCase
{
    public function testText()
    {
        $data = [
            'author' => 'Germaine',
            'title' => 11111,
            'summary' => ''
        ];
        $validator = new Validator($data, [
            'title'  => 'required|notEmpty|alpha',
            'author' => 'required|notEmpty',
            'email'  => 'email',
            'summary' => 'text'
        ]);
        $validator->validate();
        $this->assertEquals("Le champ summary n'est pas un text valide", $validator->errors()->get('summary'));
    }
}
