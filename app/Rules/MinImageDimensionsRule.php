<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class MinImageDimensionsRule implements ValidationRule
{
    public function __construct(protected float|int $minWidth, protected float|int $minHeight)
    {
    }

    /**
     * Run the validation rule.
     *
     * @param Closure(string): PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        list($width, $height) = getimagesize($value->path());

        if (!($width >= $this->minWidth && $height >= $this->minHeight)) {
            $fail('The :attribute must be at least ' . $this->minWidth . 'x' . $this->minHeight . ' pixels.');
        }
    }
}
