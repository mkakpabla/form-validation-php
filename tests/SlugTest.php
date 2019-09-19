<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use Zen\Validation\Validator;

class SlugTest extends TestCase
{

    public function testSlug()
    {
        $validator = new Validator([
            'slug'  => 'aze-aze-azeAze34',
            'slug2' => 'aze-aze_azeAze34',
            'slug4' => 'aze-azeaze-',
            'slug3' => 'aze--aze-aze'
        ], [
            'slug'  => 'slug',
            'slug2' => 'slug',
            'slug4' => 'slug',
            'slug3' => 'slug'
        ]);
        $validator->validate();
        $this->assertContains("Le champ slug n'est pas un slug valide", $validator->errors());
        $this->assertContains("Le champ slug2 n'est pas un slug valide", $validator->errors());
        $this->assertContains("Le champ slug3 n'est pas un slug valide", $validator->errors());
        $this->assertContains("Le champ slug4 n'est pas un slug valide", $validator->errors());
    }
}
