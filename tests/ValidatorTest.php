<?php

namespace Test;

use PHPUnit\Framework\TestCase;
use Zen\Validation\Validator;
class ValidatorTest extends TestCase
{

    public function testRequired()
    {
        $data = [];
        $validator = new Validator([
            'title'  => 'required|notEmpty|alpha',
            'author' => 'required|notEmpty'
            ]);
        $validator->validate($data);
        $this->assertContains('Le champ title est requis', $validator->errors());
        $this->assertContains('Le champ author est requis', $validator->errors());
        $this->assertEquals(false, $validator->isValid());
    }

    public function testNotEmpty()
    {
        $data = [
            'author' => '',
            'title' => 'Michel'
        ];
        $validator = new Validator([
            'title'  => 'required|notEmpty|alpha',
            'author' => 'required|notEmpty'
        ]);
        $validator->validate($data);
        $this->assertContains('Le champ author ne peut être vide', $validator->errors());
        $this->assertEquals(false, $validator->isValid());
    }

    public function testInteger()
    {
        $data = [
            'author' => 'Michel',
            'title' => 'Michel',
            'price' => 'toto'
        ];
        $validator = new Validator([
            'title'  => 'required|notEmpty|alpha',
            'author' => 'required|notEmpty',
            'price' => 'required|notEmpty|integer'
        ]);
        $validator->validate($data);
        $this->assertContains('le price doit être un entier(Ex: 1234)', $validator->errors());
        $this->assertEquals(false, $validator->isValid());
    }

    public function testIsValid()
    {
        $data = [
            'author' => 'Germaine',
            'title' => 'Michel'
        ];
        $validator = new Validator([
            'title'  => 'required|notEmpty|alpha',
            'author' => 'required|notEmpty'
        ]);
        $validator->validate($data);
        $this->assertEquals(true, $validator->isValid());
    }

    public function testAlpha()
    {
        $data = [
            'author' => 'Germaine',
            'title' => 11111
        ];
        $validator = new Validator([
            'title'  => 'required|notEmpty|alpha',
            'author' => 'required|notEmpty'
        ]);
        $validator->validate($data);
        $this->assertContains('Le title n\'est pas valide(Alphabétique)', $validator->errors());
    }

    public function testAlphaNum()
    {
        $data = [
            'author' => 'Germaine',
            'title' => ''
        ];
        $validator = new Validator([
            'title'  => 'alphaNum',
            'author' => 'required|notEmpty'
        ]);
        $validator->validate($data);
        $this->assertContains('Le title n\'est pas valide(Alphanumérique)', $validator->errors());
    }

    public function testEmail()
    {
        $data = [
            'author' => 'Germaine',
            'title' => 11111
        ];
        $validator = new Validator([
            'title'  => 'required|notEmpty|alpha',
            'author' => 'required|notEmpty',
            'email'  => 'email'
        ]);
        $validator->validate($data);
        $this->assertContains('Le title n\'est pas valide(Alphabétique)', $validator->errors());
        $this->assertContains('Le champ email n\'est pas un email valide', $validator->errors());
    }

    public function testText()
    {
        $data = [
            'author' => 'Germaine',
            'title' => 11111, 
            'summary' => ''
        ];
        $validator = new Validator([
            'title'  => 'required|notEmpty|alpha',
            'author' => 'required|notEmpty',
            'email'  => 'email',
            'summary' => 'text'
        ]);
        $validator->validate($data);
        $this->assertEquals("Le champ summary n'est pas un text valide", $validator->errors('summary'));
    }

    public function testLength()
    {
        $data = [
            'author' => 'Germaine',
            'author2' => 'Germaine',
        ];
        $validator = new Validator([
            'author' => 'required|length:10,20',
            'author2' => 'required|length:10'
        ]);
        $validator->validate($data);
        $this->assertEquals('Le champs author doit contenir entre 10 et 20 caractères', $validator->errors('author'));
        $this->assertEquals('Le champs author2 doit contenir plus de 10 caractères', $validator->errors('author2'));
    }
}
