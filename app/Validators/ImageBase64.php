<?php
declare( strict_types = 1 );

namespace App\Validators;

use Illuminate\Contracts\Validation\Rule;
use App\Http\Requests\Building\AddressInfoRequest;
use App\Building;

/**
 * Class ImageBase64
 * @package App\Http\Validators
 */
class ImageBase64 implements Rule
{
    /*
     * var string
     */
    public $message;

    /*
     * var array
     */
    public $mimes;
    
    /*
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        foreach ($options as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }
    
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
            //$parts = explode("base64,", $value);
            //$info = getimagesizefromstring(base64_decode($parts[1]));
            
            $pos  = strpos($value, ';');
            $mimeType = explode(':', substr($value, 0, $pos))[1];
            if (!empty($this->mimes) && !in_array($mimeType, $this->mimes)) {
                $this->message = __('Only image types: :types', ['types' => implode(', ', $this->mimes)]);
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
