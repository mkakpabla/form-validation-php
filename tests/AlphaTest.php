<?php


namespace Tests;


use PHPUnit\Framework\TestCase;
use Zen\Validation\Validator;

class AlphaTest extends TestCase
{

    public function testAlpha()
    {
        $data = [
            'author' => 'Germaine',
            'title' => 11111
        ];
        $validator = new Validator($data, [
            'title'  => 'alpha',
            'author' => 'required|notEmpty'
        ]);
        $validator->validate();
        $this->assertContains('Le title n\'est pas valide(Alphabétique)', $validator->errors());
    }

}