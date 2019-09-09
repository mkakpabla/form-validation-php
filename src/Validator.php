<?php
namespace Zen\Validation;

/**
 * class Validator
 *
 * Simple de Validator class
 *
 * @author Michel Akpabla <michel.akpabla2@gmail.com>
 * @copyright (c) 2019, Michel Akpabla
 */
class Validator
{

    /**
     * @var array
     */
    public $patterns = [
        'alpha'         => '/[a-zA-Z]+/',
        'alphaNum'      => '/[a-zA-Z0-9]+/',
        'slug'          => '/[a-zA-Z0-9-]+/',
        'integer'       => '/[0-9]+/',
        'text'          => '/[a-zA-Z0-9-_ ]+/'
    ];

    /**
     * @var array
     */
    private $message = [
        'required'          => 'Le champ %s est requis',
        'alpha'             => 'Le %s n\'est pas valide(Alphabétique)',
        'alphaNum'          => 'Le %s n\'est pas valide(Alphanumérique)',
        'notEmpty'          => 'Le champ %s ne peut être vide',
        'integer'           => 'le %s doit être un entier(Ex: 1234)',
        'email'             => "Le champ %s n'est pas un email valide",
        'text'              => "Le champ %s n'est pas un text valide",
        'min'               => 'Le champs %s doit contenir plus de %d caractères',
        'max'               => 'Le champs %s doit contenir moins de %d caractères',
        'between'           => 'Le champs %s doit contenir entre %d et %d caractères',
        'datetime'          => 'Le champs %s doit être une date valide'
    ];
    /**
     * @var array
     */
    private $datas = [];

    /**
     * @var array
     */
    private $errors = [];

    /**
     * @var array
     */
    private $rules;

    /**
     * Validator constructor.
     * @param array $rules
     */
    public function __construct(array $rules)
    {
        $this->rules = $rules;
    }

    /**
     * @param array $datas
     * @return $this
     * @throws \Exception
     */
    public function validate(array $datas): self
    {
        $this->datas = $datas;
        $this->ruleParse();
        return $this;
    }

    /**
     * @param string|null $key
     * @return array|string
     */
    public function errors(?string $key = null)
    {
        if(is_null($key)) {
            return $this->errors;
        }
        return $this->errors[$key];
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return empty($this->errors);
    }


    private function ruleParse()
    {
        foreach ($this->rules as $key => $rules) {
            foreach ($rules as $rule) {
                if (preg_match("/[a-z]+/", $rule)) {
                    if (method_exists($this, $rule)) {
                        call_user_func_array([$this, $rule], [$key, $rule]);
                    } else {
                        throw new UndifedRuleException('Undifed Rule ' . $rule);
                    }
                }
            }
        }
    }

    /**
     * @param string $key
     * @param string $rule
     * @param array|null $attributes
     */
    private function addError(string $key, string $rule, ?array $attributes = [])
    {
        if (!array_key_exists($key, $this->errors)) {
            if (array_key_exists($rule, $this->message)) {
                $params = array_merge([$this->message[$rule], $key], $attributes);
                $this->errors[$key] = (string)call_user_func_array('sprintf', $params);
            }
        }
    }

    /**
     * @param string $key
     * @return mixed|null
     */
    private function getValue(string $key)
    {
        if (array_key_exists($key, $this->datas)) {
            return $this->datas[$key];
        }
        return null;
    }

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
        if (!preg_match($this->patterns[$rule], $value)) {
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
        if (!preg_match($this->patterns[$rule], $value)) {
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
        if(!preg_match($this->patterns[$rule], $value)) {
            $this->addError($key, $rule);
        }
    }



    private function length(string $key, string $rule, $params)
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
