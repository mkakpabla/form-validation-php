<?php


namespace Zen\Validation\Rules;

use Zen\Validation\RuleInterface;
use Zen\Validation\Validator;

class NotEmpty implements RuleInterface
{

    public function __invoke(Validator $validator, string $key, string $rule): void
    {
        $value = $validator->getValue($key);
        if (is_null($value) || empty($value)) {
            $validator->addError($key, $rule);
        }
    }
}
