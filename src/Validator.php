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
    use Rules;

    /**
     * @var array
     */
    public $patterns = [
        'alpha'         => '[\p{L}]+',
        'alphaNum'      => '[\p{L}0-9]+',
        'slug'          => '/[a-zA-Z0-9-]+/',
        'integer'       => '/[0-9]+/',
        'text'          => '[\p{L}0-9\s-.,;:!"%&()?+\'°#\/@]+'
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
     * @var array
     */
    private $inputs;

    /**
     * Validator constructor.
     * @param array $inputs
     * @param array $rules
     */
    public function __construct(array $inputs, array $rules)
    {
        $this->rules = $rules;
        $this->inputs = $inputs;
    }

    /**
     * @return $this
     * @throws UndifedRuleException
     */
    public function validate(): self
    {
        $this->callRules();
        return $this;
    }

    /**
     * @return Errors
     */
    public function errors(): Errors
    {
        return new Errors($this->errors);
    }

    /**
     * @param array $messages
     * @return $this
     */
    public function addErrorsMessages(array $messages)
    {
        $this->message = array_merge($this->message, $messages);
        return $this;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return empty($this->errors);
    }


    /**
     * @return array
     */
    private function ruleParse()
    {
        $rules = [];
        foreach ($this->rules as $key => $rule) {
            $rules[$key] = explode('|', $rule);
        }
        return $rules;
    }

    /**
     * @throws UndifedRuleException
     */
    private function callRules()
    {
        $regex = '/^('.$this->patterns['alpha'].')$/u';
        foreach ($this->ruleParse() as $key => $rules) {

            foreach ($rules as $rule) {
                $rule = trim($rule);
                if (preg_match($regex, $rule)) {
                    if (method_exists($this, $rule)) {
                        call_user_func_array([$this, $rule], [$key, $rule]);
                    } else {
                        throw new UndifedRuleException('Undifed Rule ' . $rule);
                    }
                } else {
                    $pieces = explode(':', $rule);
                    $rule = trim($pieces[0]);
                    $params = explode(',', $pieces[1]);
                    if (method_exists($this, $rule)) {
                        call_user_func_array([$this, $rule], [$key, $rule, $params]);
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
            if (array_key_exists($key .'.'.$rule, $this->message)) {
                $this->errors[$key] = $this->message[$key .'.'.$rule];
            } elseif (array_key_exists($rule, $this->message)) {
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
        if (array_key_exists($key, $this->inputs)) {
            return $this->inputs[$key];
        }
        return null;
    }

}
