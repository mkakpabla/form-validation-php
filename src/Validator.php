<?php
namespace Zenthos\Validation;

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
        'slug'          => '/[a-zA-Z0-9-]+/',
        'integer'       => '/[0-9]+/',
        'text'          => '/[a-zA-Z0-9-_ ]+/'
    ];

    /**
     * @var array
     */
    private $message = [
        
        'required'   => 'Le champ %s est requis',
        'alpha'      => 'Le %s  n\'est pas valide(Alphabétique)',
        'notEmpty'   => 'Le champ %s ne peut être vide',
        'integer'    => 'le %s doit être un entier(Ex: 1234)',
        'email'      => "Le champ %s n'est pas un email valide",
        'text'       => "Le champ %s n'est pas un text valide"
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
     */
    public function validate(array $datas): self
    {
        $this->datas = $datas;
        foreach ($this->rules as $key => $rule) {
            $rules = explode('|', $rule);
            foreach ($rules as $rule) {
                $this->$rule($key, $rule);
            }
            /*
            if (in_array('required', $rules)) {
                $this->required($key, 'required');
            }
            if (in_array('notEmpty', $rules)) {
                $this->notEmpty($key, 'notEmpty');
            }
            if (in_array('alpha', $rules)) {
                $this->alpha($key, 'alpha');
            }
            if (in_array('integer', $rules)) {
                $this->integer($key, 'integer');
            }*/
        }
        return $this;
    }

    /**
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

    /**
     * @param string $key
     * @param string $rule
     */
    private function addError(string $key, string $rule)
    {
        if (!array_key_exists($key, $this->errors)) {
            if (array_key_exists($rule, $this->message)) {
                $this->errors[$key] = sprintf($this->message[$rule], $key);
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
     */
    private function required(string $key, string $rule): void
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
}
