<?php


namespace Tests {


    use PHPUnit\Framework\TestCase;
    use Zen\Validation\Validator;

    class BetweenTest extends TestCase
    {

        public function testMaxIsFaill()
        {
            $validator = new Validator([
                'content' => 'ddddddddddddd'
            ], [
                'content' => 'between:3,5'
            ]);
            $validator->validate();
            $this->assertContains('Le champ content doit contenir entre 3 et 5 caractères', $validator->errors());
            $this->assertEquals(false, $validator->isValid());
        }

        public function testMaxIsValid()
        {
            $validator = new Validator([
                'content' => 'michel'
            ], [
                'content' => 'between:3,7'
            ]);
            $validator->validate();
            $this->assertEquals(true, $validator->isValid());
        }
    }
}
