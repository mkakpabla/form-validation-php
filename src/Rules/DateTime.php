<?php


namespace Zen\Validation\Rules;

use Zen\Validation\RuleInterface;
use Zen\Validation\Validator;

class DateTime implements RuleInterface
{

    private $format = 'Y-m-d H:i:s';

    public function __invoke(Validator $validator, string $key, string $rule): void
    {
        $value = $validator->getValue($key);
        $date = \DateTime::createFromFormat($this->format, $value);
        $errors = \DateTime::getLastErrors();
        if ($errors['error_count'] > 0 || $errors['warning_count'] > 0 || $date === false) {
            $validator->addError($key, 'datetime', [$this->format]);
        }
    }
}
