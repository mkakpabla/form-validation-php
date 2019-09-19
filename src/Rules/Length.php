<?php


namespace Zen\Validation\Rules;

use Zen\Validation\RuleInterface;
use Zen\Validation\Validator;

class Length implements RuleInterface
{


    /**
     * @var array
     */
    private $params;

    public function __construct(array $params)
    {
        $this->params = $params;
    }

    public function __invoke(Validator $validator, string $key, string $rule): void
    {
        $value = $validator->getValue($key);
        $length = mb_strlen($value);
        if (count($this->params) === 2) {
            $min = (int)min($this->params);
            $max = (int)max($this->params);
            if (!is_null($min) && !is_null($max) && ($length < $min || $length > $max)) {
                $validator->addError($key, 'between', [$min, $max]);
            }
        } elseif (count($this->params) === 1) {
            $min = (int)min($this->params);
            if (!is_null($min) && $length < $min) {
                $validator->addError($key, 'min', [$min]);
            }
        }
    }
}
