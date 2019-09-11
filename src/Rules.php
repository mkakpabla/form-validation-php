<?php


namespace Zen\Validation;


trait Rules
{

    /***
     * Vérifie si le champ existe
     * @param string $key
     * @param string $rule
     * @return void
     */
    private function required(string $key, string $rule)
    {
        $value = $this->getValue($key);
        if (is_null($value)) {
            $this->addError($key, $rule);
        }
    }

    /**
     * @param string $key
     * @param string $rule
     */
    private function notEmpty(string $key, string $rule)
    {
        $value = $this->getValue($key);
        if (is_null($value) || empty($value)) {
            $this->addError($key, $rule);
        }
    }

    /**
     * @param string $key
     * @param string $rule
     */
    private function alpha(string $key, string $rule)
    {
        $value = $this->getValue($key);
        $regex = '/^('.$this->patterns[$rule].')$/u';
        if (!preg_match($regex, $value)) {
            $this->addError($key, $rule);
        }
    }

    /**
     * @param string $key
     * @param string $rule
     */
    private function alphaNum(string $key, string $rule)
    {
        $value = $this->getValue($key);
        $regex = '/^('.$this->patterns[$rule].')$/u';
        if (!preg_match($regex, $value)) {
            $this->addError($key, $rule);
        }
    }

    /**
     * @param string $key
     * @param string $rule
     */
    private function integer(string $key, string $rule)
    {
        $value = $this->getValue($key);
        if (!preg_match($this->patterns[$rule], $value)) {
            $this->addError($key, $rule);
        }
    }

    private function email(string $key, string $rule)
    {
        $value = $this->getValue($key);
        if(!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->addError($key, $rule);
        }
    }

    private function text(string $key, string $rule)
    {
        $value = $this->getValue($key);
        $regex = '/^('.$this->patterns[$rule].')$/u';
        if(!preg_match($regex, $value)) {
            $this->addError($key, $rule);
        }
    }



    private function length(string $key, string $rule, array $params)
    {
        $value = $this->getValue($key);
        $length = mb_strlen($value);
        if (count($params) === 2) {
            $min = (int)min($params);
            $max = (int)max($params);
            if (!is_null($min) && !is_null($max) && ($length < $min || $length > $max)) {
                $this->addError($key, 'between', [$min, $max]);
            }
        } elseif (count($params) === 1) {
            $min = (int)min($params);
            if (!is_null($min) && $length < $min) {
                $this->addError($key, 'min', [$min]);
            }
        }
    }

}