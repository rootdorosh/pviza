<?php
declare( strict_types = 1 );

namespace App\Modules\Structure\Http\Requests\Page;

use App\Base\Requests\BaseFormRequest;
use App\Modules\Structure\Services\StructureService;
use App\Modules\Structure\Http\Validators\CopyPage;

/**
 * Class FormRequest
 * 
 * @package App\Modules\Structure
 *
 */

class CopyRequest extends BaseFormRequest
{
    /*
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->hasPermission('structure.page.copy');
    }
    
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'page' => [
                new CopyPage($this),
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
