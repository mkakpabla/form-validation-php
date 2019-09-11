<?php


namespace Tests;


use PHPUnit\Framework\TestCase;
use Zen\Validation\Validator;

class NotEmptyTest extends TestCase
{

    public function testNotEmpty()
    {
        $data = [
            'author' => '',
            'title' => 'Michel'
        ];
        $validator = new Validator($data, [
            'title'  => 'notEmpty',
            'author' => 'notEmpty'
        ]);
        $validator->validate();
        $this->assertContains('Le champ author ne peut être vide', $validator->errors());
        $this->assertEquals(false, $validator->isValid());
    }

}