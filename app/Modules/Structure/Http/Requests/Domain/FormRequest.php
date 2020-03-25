<?php
declare( strict_types = 1 );

namespace App\Modules\Structure\Http\Requests\Domain;

use Illuminate\Support\Arr;
use App\Base\Requests\BaseFormRequest;
use App\Base\Validators\ImageBase64;

/**
 * Class FormRequest
 * 
 * @package App\Modules\Structure
 *
 * @bodyParam alias             string   required Alias.
 * @bodyParam is_active         integer  required Active. Value: 0, 1
 * @bodyParam site_lang         string   required Domain default language
 * @bodyParam site_langs        array    required Domain languages
 * @bodyParam logo_base64       file     optional Domain logo base64 encoded
 * @bodyParam lang[copyright]   string   optional Copyright text.
 */
class FormRequest extends BaseFormRequest
{
    /*
     * @return bool
     */
    public function authorize(): bool
    {
        $action = empty($this->event) ? 'store' : 'update';
        
        return $this->user()->hasPermission('structure.domain.' . $action);
    }
    
    /**
     * @return array
     */
    public function rules(): array
    {
        $rules = [
            'alias' => [
                'required',
                'string',
                !empty($this->domain) ? 'unique:structure_domains,id,' . $this->domain->id : 'unique:structure_domains',
            ],           
            'is_active' => [
                'required',
                'integer',
                'in:0,1',
            ],
            'logo_base64' => [
                'nullable',
                'base64dimensions:min_width=100,min_height=80',
            ],      
            'logo_name' => [
                'nullable',
                'string',
            ],
            'site_lang' => [
                'required',
                'string',
                'in:' . implode(',', config('translatable.locales')),
            ],
            'site_langs' => [
                'required',
                'array',
            ],
            'site_langs.*' => [
                'string',
                'distinct',
                'in:' . implode(',', config('translatable.locales')),
            ],
        ];
        
        foreach (config('translatable.locales') as $locale) {
            $rules[$locale . '.copyright'] = [
                'nullable',
                'string',
            ];
        }
        
        return $rules;
    }
    
    /*
     * @return array
     */
    public function attributes(): array
    {
        return $this->getAttributesLabels('Structure', 'Domain', true);
    }
}
