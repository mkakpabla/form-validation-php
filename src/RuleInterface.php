<?php
namespace Zen\Validation;

interface RuleInterface
{

    public function __invoke(Validator $validator, string $key, string $rule): void;
}
