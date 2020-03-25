<?php
declare( strict_types = 1 );

namespace App\Validators;

use Illuminate\Contracts\Validation\Rule;
use App\Http\Requests\Building\AddressInfoRequest;
use App\Building;

/**
 * Class Phone
 * @package App\Http\Validators
 */
class Phone implements Rule
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
            if (!preg_match("/^\+38\s\(\d{3}\)\s\d{3}\s\d{2}\s\d{2}$/", $value)) {
                $this->message = __('validation.phone_is_not_valid');
            }
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
