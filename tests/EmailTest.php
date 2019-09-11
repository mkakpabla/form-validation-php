<?php


namespace Tests;


use PHPUnit\Framework\TestCase;
use Zen\Validation\Validator;

class EmailTest extends TestCase
{
    public function testEmail()
    {
        $data = [
            'author' => 'Germaine',
            'title' => 11111
        ];
        $validator = new Validator($data, [
            'title'  => 'required|notEmpty|alpha',
            'author' => 'required|notEmpty',
            'email'  => 'email'
        ]);
        $validator->validate();
        $this->assertContains('Le title n\'est pas valide(Alphabétique)', $validator->errors());
        $this->assertContains('Le champ email n\'est pas un email valide', $validator->errors());
    }

}