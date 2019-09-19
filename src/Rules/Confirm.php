<?php


namespace Zen\Validation\Rules;

use Zen\Validation\RuleInterface;
use Zen\Validation\Validator;

class Confirm implements RuleInterface
{


    public function __invoke(Validator $validator, string $key, string $rule): void
    {
        $value = $validator->getValue($key);
        $valueConfirm = $validator->getValue($key . '_confirm');
        if ($valueConfirm !== $value) {
            $validator->addError($key, $rule);
        }
    }
}
