<?php


namespace Tests;


use PHPUnit\Framework\TestCase;
use Zen\Validation\Validator;

class AlphaNumTest extends TestCase
{


    public function testAlphaNum()
    {
        $data = [
            'author' => 'Germaine',
            'title' => ''
        ];
        $validator = new Validator($data, [
            'title'  => 'alphaNum',
            'author' => 'required|notEmpty'
        ]);
        $validator->validate();
        $this->assertContains('Le title n\'est pas valide(Alphanumérique)', $validator->errors());
    }

}