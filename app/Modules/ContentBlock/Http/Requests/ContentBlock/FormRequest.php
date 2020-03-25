<?php 

declare( strict_types = 1 );

namespace App\Modules\ContentBlock\Http\Requests\ContentBlock;

use App\Base\Requests\BaseFormRequest; 
use App\Validators\ImageBase64; 
use App\Validators\ImageAdaptive;

/**
 * Class FormRequest
 * 
 * @package  App\Modules\ContentBlock
 *
 * @bodyParam image  image optional  Image
 * @bodyParam name  string required  Name
 * @bodyParam is_active  integer required  Active
 * @bodyParam is_hide_editor  integer required  Hide editor
 * @bodyParam adaptive_image  string optional  Adaptive images
 * @bodyParam lang[title]  string required  Title
 * @bodyParam lang[body]  string required  Body

 */
class FormRequest extends BaseFormRequest
{
    /*
     * @return  bool
     */
    public function authorize(): bool
    {
        $action = empty($this->content_block) ? 'store' : 'update';
        
        return $this->user()->hasPermission('contentblock.contentblock.' . $action);
    }
    
    /**
     * @return  array
     */
    public function rules(): array
    {
        $rules = [
            'image.content' => [
                'nullable',
                'string',
                new ImageBase64(),
            ],
            'image.name' => [
                'nullable',
                'string',
            ],
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'is_active' => [
                'required',
                'integer',
                'in:0,1',
            ],
            'is_hide_editor' => [
                'required',
                'integer',
                'in:0,1',
            ],
            'adaptive_image' => [
                'nullable',
                'array',
                new ImageAdaptive(),
            ],
        ];

        foreach (config('translatable.locales') as $locale) {
            $rules[$locale.'.title'] = [
                'required',
                'string',
                'max:255',
            ];
            $rules[$locale.'.body'] = [
                'required',
                'string',
                'max: 10024',
            ];
        }

		return $rules;
	}
    
    /*
     * @return  array
     */
    public function attributes(): array
    {
        return $this->getAttributesLabels('ContentBlock', 'ContentBlock', true);
    }
}