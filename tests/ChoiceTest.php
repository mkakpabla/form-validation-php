<?php


namespace Tests;

use PHPUnit\Framework\TestCase;
use Zen\Validation\Validator;

class ChoiceTest extends TestCase
{

    public function testChoiceIsNotvalid()
    {
        $data = [
            'author' => 'Text',
        ];
        $validator = new Validator($data, [
            'author' => 'required|choice:Germaine,Gregoire,Michel',
        ]);
        $validator->validate();
        $this->assertContains(
            'La valeur du champ author doit être dans cette liste (Germaine, Gregoire, Michel)',
            $validator->errors()
        );
        $this->assertEquals(false, $validator->isValid());
    }

    public function testChoiceIsvalid()
    {
        $data = [
            'author' => 'Michel',
        ];
        $validator = new Validator($data, [
            'author' => 'required|choice:Germaine,Gregoire,Michel',
        ]);
        $validator->validate();
        $this->assertEquals(true, $validator->isValid());
    }
}
