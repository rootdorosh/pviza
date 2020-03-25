<?php
declare( strict_types = 1 );

namespace App\Validators;

use Illuminate\Contracts\Validation\Rule;
use App\Http\Requests\Building\AddressInfoRequest;
use App\Building;

/**
 * Class ImageAdaptive
 * @package App\Http\Validators
 */
class ImageAdaptive implements Rule
{
    /*
     * var string
     */
    public $message;

    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        if (!empty($value)) {
            
        }

        return empty($this->message) ? true : false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->message;
    }
}
