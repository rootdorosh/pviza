<?php

namespace App\Base\Requests;
 
/**
 * Class BaseIndexSimpleRequest
 * @package App\Http\Requests
 */
abstract class BaseIndexSimpleRequest extends BaseRequest
{
    /*
     * @return bool
     */
    abstract public function authorize(): bool;
    
    /*
     * return array
     */
    public function rules(): array
    {
        return [];
    }
    
}
