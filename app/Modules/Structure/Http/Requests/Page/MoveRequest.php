<?php
declare( strict_types = 1 );

namespace App\Modules\Structure\Http\Requests\Page;

use App\Base\Requests\BaseFormRequest;
use App\Modules\Structure\Services\StructureService;
use App\Modules\Structure\Http\Validators\MovePage;

/**
 * Class FormRequest
 * 
 * @package App\Modules\Structure
 *
 * @bodyParam parent_id integer required Parent page
 */

class MoveRequest extends BaseFormRequest
{
    /*
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->hasPermission('structure.page.move');
    }
    
    /**
     * @return array
     */
    public function rules(): array
    {
        return  [
            'parent_id' => [
                'required',
                new MovePage($this),
            ],
        ];
    }
    
    /*
     * @return array
     */
    public function attributes(): array
    {
        return $this->getAttributesLabels('Structure', 'Page', true);
    }
}
