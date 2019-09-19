<?php


namespace Tests;

use PHPUnit\Framework\TestCase;
use Zen\Validation\Validator;

class RequiredTest extends TestCase
{

    public function testRequired()
    {
        $data = [];
        $validator = new Validator($data, [
            'title'  => 'required',
            'author' => 'required'
        ]);
        $validator->validate();
        $this->assertContains('Le champ title est requis', $validator->errors());
        $this->assertContains('Le champ author est requis', $validator->errors());
        $this->assertEquals(false, $validator->isValid());
    }
}
