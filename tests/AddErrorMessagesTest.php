<?php


namespace Tests;


use PHPUnit\Framework\TestCase;
use Zen\Validation\Validator;

class AddErrorMessagesTest extends TestCase
{

    public function testAddErrorsMessages()
    {
        $data = [
            'author' => '',
        ];
        $validator = new Validator($data, [
            'title'  => 'required|alphaNum',
            'author' => 'required|notEmpty'
        ]);
        $validator->addErrorsMessages([
            'title.required' => "le titre est obligatoire"
        ])
            ->validate();
        $this->assertContains('le titre est obligatoire', $validator->errors());
    }

}