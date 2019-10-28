<?php
namespace Zen\Validation;

class ValidationError
{

    private $key;

    private $rule;

    private $messages = [
        'required'          => 'Le champ %s est requis',
        'alpha'             => 'Le %s n\'est pas valide(Alphabétique)',
        'alphaNum'          => 'Le %s n\'est pas valide(Alphanumérique)',
        'notEmpty'          => 'Le champ %s ne peut être vide',
        'integer'           => 'le %s doit être un entier(Ex: 1234)',
        'email'             => "Le champ %s n'est pas un email valide",
        'text'              => "Le champ %s n'est pas un text valide",
        'min'               => 'Le champ %s doit contenir plus de %d caractères',
        'max'               => 'Le champ %s doit contenir moins de %d caractères',
        'between'           => 'Le champ %s doit contenir entre %d et %d caractères',
        'datetime'          => 'Le champ %s doit être une date valide',
        'time'              => 'Le champ %s doit être une heur valide',
        'date'              => 'Le champ %s doit être une date valide',
        'confirm'           => 'Vous n\'avez pas confirmé le champs %s',
        'slug'              => 'Le champ %s n\'est pas un slug valide',
        'file'              => 'Le champ %s doit être un fichier valide',
        'choice'            => 'La valeur du champ %s doit être dans cette liste (%s)'

    ];
    /**
     * @var array
     */
    private $attributes;

    public function __construct(string $key, string $rule, array $attributes = [])
    {
        $this->key = $key;
        $this->rule = $rule;
        $this->attributes = $attributes;
    }

    public function __toString()
    {
        if (!array_key_exists($this->rule, $this->messages)) {
            return "Le champs {$this->key} ne correspond pas à la règle {$this->rule}";
        } else {
            $params = array_merge([$this->messages[$this->rule], $this->key], $this->attributes);
            return (string)call_user_func_array('sprintf', $params);
        }
    }
}
