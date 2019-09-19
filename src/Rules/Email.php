<?php


namespace Zen\Validation\Rules;

use Zen\Validation\RuleInterface;
use Zen\Validation\Validator;

class Email implements RuleInterface
{

    public function __invoke(Validator $validator, string $key, string $rule): void
    {
        $value = $validator->getValue($key);
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $validator->addError($key, $rule);
        }
    }
}
