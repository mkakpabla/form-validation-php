<?php


namespace Zen\Validation\Rules;

use Zen\Validation\RuleInterface;
use Zen\Validation\Validator;

class Alpha implements RuleInterface
{

    private $pattern = '[\p{L}]+';

    public function __invoke(Validator $validator, string $key, string $rule): void
    {
        $value = $validator->getValue($key);
        $regex = '/^('.$this->pattern.')$/u';
        if (!preg_match($regex, $value)) {
            $validator->addError($key, $rule);
        }
    }
}
