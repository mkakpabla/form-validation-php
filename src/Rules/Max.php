<?php
namespace Zen\Validation\Rules;

use http\Exception;
use Zen\Validation\RuleInterface;
use Zen\Validation\Validator;

class Max implements RuleInterface
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
            $max = (int)max($this->params);
            if (!is_null($max) && $length > $max) {
                $validator->addError($key, 'max', [$max]);
            }
        } else {
            throw new \Exception("The max rule take only one parameter");
        }
    }
}
