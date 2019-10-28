<?php


namespace Tests;

use PHPUnit\Framework\TestCase;
use Zen\Validation\Validator;

class FileTest extends TestCase
{



    public function testFileIsInvalid()
    {

        $validator = (new Validator([
            'image' => ''
        ], [
            'image' => 'file'
        ]))->validate();
    }
}