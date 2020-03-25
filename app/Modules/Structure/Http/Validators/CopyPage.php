<?php
declare( strict_types = 1 );

namespace App\Modules\Structure\Http\Validators;

use Illuminate\Contracts\Validation\Rule;
use App\Modules\Structure\Services\StructureService;
use App\Modules\Structure\Models\Page;
use App\Base\Requests\BaseFormRequest;

/**
 * Class CopyPage
 * @package App\Modules\Auth
 */
class CopyPage implements Rule
{
    /*
     * @var string
     */
    private $message;

    /*
     * @var BaseFormRequest
     */
    private $request;
    
    /**
     *
     * @param BaseFormRequest $request
     */
    public function __construct(BaseFormRequest $request)
    {
        $this->request = $request;
    }
    
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (strlen($this->request->page->structure_id) === StructureService::ID_PART_LEN) {
            $this->message = __('structure::validation.root_page_cannot_be_copied');
        }
        
        return $this->message === null;
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
