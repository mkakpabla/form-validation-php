<?php


namespace Tests;

use PHPUnit\Framework\TestCase;
use Zen\Validation\Validator;

class ConfirmTest extends TestCase
{

    public function testConfirm()
    {
        $data = [
            'password' => 'Germaine',
        ];
        $validator = new Validator($data, [
            'password'  => 'confirm',
        ]);
        $validator->validate();
        $this->assertContains('Vous n\'avez pas confirmé le champs password', $validator->errors());
    }
}
