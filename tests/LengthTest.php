<?php


namespace Tests;

use PHPUnit\Framework\TestCase;
use Zen\Validation\Validator;

class LengthTest extends TestCase
{

    public function testLength()
    {
        $data = [
            'author' => 'Germaine',
            'author2' => 'Germaine',
        ];
        $validator = new Validator($data, [
            'author' => 'required   |length:10,20',
            'author2' => 'required|length:10'
        ]);
        $validator->validate();
        $this->assertEquals(
            'Le champs author doit contenir entre 10 et 20 caractères',
            $validator->errors()->get('author')
        );
        $this->assertEquals(
            'Le champs author2 doit contenir plus de 10 caractères',
            $validator->errors()->get('author2')
        );
    }
}
