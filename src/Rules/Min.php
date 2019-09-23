<?php


namespace Zen\Validation\Rules;

use Zen\Validation\RuleInterface;
use Zen\Validation\Validator;

class Min implements RuleInterface
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
        if (count($this->params) === 1) {
            $min = (int)min($this->params);
            if (!is_null($min) && $length < $min) {
                $validator->addError($key, 'min', [$min]);
            }
        } else {
            throw new \Exception("The min rule take only one parameter");
        }
    }
}
