<?php
namespace Zen\Validation\Rules;

use Zen\Validation\RuleInterface;
use Zen\Validation\Validator;

class File implements RuleInterface
{

    private const MIME_TYPES = [
        'jpg' => 'image/jpeg',
        'png' => 'image/png',
        'pdf' => 'application/pdf'
    ];
    /**
     * @var array
     */
    private $extensions;

    public function __construct(array $extensions)
    {
        $this->extensions = $extensions;
    }

    public function __invoke(Validator $validator, string $key, string $rule): void
    {
        $file = $validator->getValue($key);
        if ($file instanceof Upload)
        if ($file !== null && $file->getError() === UPLOAD_ERR_OK) {
            $type = $file->getClientMediaType();
            $extension = mb_strtolower(pathinfo($file->getClientFilename(), PATHINFO_EXTENSION));
            $expectedType = self::MIME_TYPES[$extension] ?? null;
            if (!in_array($extension, $this->extensions) || $expectedType !== $type) {
                $validator->addError($key, 'filetype', [join(',', $this->extensions)]);
            }
        }
    }
}