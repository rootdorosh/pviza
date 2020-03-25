<?php

namespace App\Base\Requests;
 
/**
 * Class BaseShowRequest
 * @package App\Http\Requests
 */
abstract class BaseShowRequest extends BaseRequest
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
