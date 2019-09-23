<?php
namespace Zen\Validation;

use Zen\Validation\Rules\Alpha;
use Zen\Validation\Rules\AlphaNum;
use Zen\Validation\Rules\Between;
use Zen\Validation\Rules\Confirm;
use Zen\Validation\Rules\DateTime;
use Zen\Validation\Rules\Email;
use Zen\Validation\Rules\Integer;
use Zen\Validation\Rules\Length;
use Zen\Validation\Rules\Max;
use Zen\Validation\Rules\Min;
use Zen\Validation\Rules\NotEmpty;
use Zen\Validation\Rules\Required;
use Zen\Validation\Rules\Slug;
use Zen\Validation\Rules\Text;
use Zen\Validation\Rules\Time;

/**
 * class Validator
 * @author Michel Akpabla <michel.akpabla2@gmail.com>
 * @copyright (c) 2019, Michel Akpabla
 */
class Validator
{

    /**
     * Liste des regles de validation
     * @var array
     */
    private $rulesList = [
        'required'        => Required::class,
        'alpha'           => Alpha::class,
        'alphaNum'        => AlphaNum::class,
        'email'           => Email::class,
        'notEmpty'        => NotEmpty::class,
        'integer'         => Integer::class,
        'text'            => Text::class,
        'confirm'         => Confirm::class,
        'datetime'        => DateTime::class,
        'time'            => Time::class,
        'slug'            => Slug::class,
        'min'             => Min::class,
        'max'             => Max::class,
        'between'         => Between::class,
    ];

    private $rules = [];

    /**
     * Les messages d'erreurs
     * @var array
     */
    private $customMessages = [];

    /**
     * La liste des erreurs après validation
     * @var array
     */
    private $errors = [];

    /**
     * Les données à valider
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
     * Permet l'ajout des erreurs personnalisés
     * @param array $messages
     * @return $this
     */
    public function addErrorsMessages(array $messages)
    {
        $this->customMessages = array_merge($this->customMessages, $messages);
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
        $pattern = '[\p{L}]+';
        $regex = '/^('.$pattern.')$/u';
        foreach ($this->ruleParse() as $key => $rules) {
            foreach ($rules as $rule) {
                $rule = trim($rule);
                if (preg_match($regex, $rule)) {
                    if (array_key_exists($rule, $this->rulesList)) {
                        call_user_func_array(new $this->rulesList[$rule](), [$this, $key, $rule]);
                    } else {
                        throw new UndifedRuleException('Undifed Rule ' . $rule);
                    }
                } else {
                    $pieces = explode(':', $rule);
                    $rule = trim($pieces[0]);
                    $params = explode(',', $pieces[1]);
                    if (array_key_exists($rule, $this->rulesList)) {
                        call_user_func_array(new $this->rulesList[$rule]($params), [$this, $key, $rule]);
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
    public function addError(string $key, string $rule, ?array $attributes = [])
    {
        if (!array_key_exists($key, $this->errors)) {
            if (array_key_exists($key .'.'.$rule, $this->customMessages)) {
                $this->errors[$key] = $this->customMessages[$key .'.'.$rule];
            } else {
                $this->errors[$key] = (string)(new ValidationError($key, $rule, $attributes));
            }
        }
    }

    /**
     * @param string $key
     * @return mixed|null
     */
    public function getValue(string $key)
    {
        if (array_key_exists($key, $this->inputs)) {
            return $this->inputs[$key];
        }
        return null;
    }
}
