<?php


namespace Zen\Validation\Rules;

use Zen\Validation\RuleInterface;
use Zen\Validation\Validator;

class Required implements RuleInterface
{


    //private $message = 'Le champ %s est requis';

    public function __invoke(Validator $validator, string $key, string $rule): void
    {
        $value = $validator->getValue($key);
        if (is_null($value)) {
            $validator->addError($key, $rule);
        }
    }
}
