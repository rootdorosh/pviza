<?php

namespace App\Base\Requests;
 
/**
 * Class BaseMetaRequest
 * @package App\Http\Requests
 */
abstract class BaseMetaRequest extends BaseRequest
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
