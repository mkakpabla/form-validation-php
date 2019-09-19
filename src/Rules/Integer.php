<?php


namespace Zen\Validation\Rules;

use Zen\Validation\RuleInterface;
use Zen\Validation\Validator;

class Integer implements RuleInterface
{

    private $pattern = '/[0-9]+/';

    public function __invoke(Validator $validator, string $key, string $rule): void
    {
        $value = $validator->getValue($key);
        if (!preg_match($this->pattern, $value)) {
            $validator->addError($key, $rule);
        }
    }
}
