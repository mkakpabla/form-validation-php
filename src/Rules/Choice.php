<?php
namespace Zen\Validation\Rules;

use Zen\Validation\RuleInterface;
use Zen\Validation\Validator;

class Choice implements RuleInterface
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
        if (count($this->params) <= 3) {
            if (!in_array($value, $this->params)) {
                $params = implode(', ', $this->params);
                $validator->addError($key, 'choice', [$params]);
            }
        } else {
            throw new \Exception("The choice rule not be take except 3 paramaters");
        }
    }
}