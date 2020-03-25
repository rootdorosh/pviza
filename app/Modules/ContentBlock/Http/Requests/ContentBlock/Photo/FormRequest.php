<?php 

declare( strict_types = 1 );

namespace App\Modules\ContentBlock\Http\Requests\ContentBlock\Photo;

use App\Base\Requests\BaseFormRequest; 
use App\Validators\ImageBase64;

/**
 * Class FormRequest
 * 
 * @package  App\Modules\ContentBlock
 *
 * @bodyParam image  image optional  Image
 * @bodyParam is_active  integer required  Active
 * @bodyParam type  integer optional  Type
 * @bodyParam lang[title]  string required  Title
 * @bodyParam lang[description]  string optional  Description

 */
class FormRequest extends BaseFormRequest
{
    /*
     * @return  bool
     */
    public function authorize(): bool
    {
        $action = empty($this->content_block_photo) ? 'store' : 'update';
        
        return $this->user()->hasPermission('contentblock.contentblock.photo.' . $action);
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
            'is_active' => [
                'required',
                'integer',
                'in:0,1',
            ],
            'type' => [
                'nullable',
                'integer',
            ],
        ];

        foreach (config('translatable.locales') as $locale) {
            $rules[$locale.'.title'] = [
                'required',
                'string',
                'max:255',
            ];
            $rules[$locale.'.description'] = [
                'nullable',
                'string',
                'max:1024',
            ];
        }

		return $rules;
	}
    
    /*
     * @return  array
     */
    public function attributes(): array
    {
        return $this->getAttributesLabels('ContentBlock', 'ContentBlock.Photo', true);
    }
}