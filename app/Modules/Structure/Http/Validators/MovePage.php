<?php
declare( strict_types = 1 );

namespace App\Modules\Structure\Http\Validators;

use Illuminate\Contracts\Validation\Rule;
use App\Modules\Structure\Models\Page;
use App\Base\Requests\BaseFormRequest;

/**
 * Class MovePage
 * @package App\Modules\Auth
 */
class MovePage implements Rule
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
        $parentPage = Page::find($this->request->parent_id);

        if (!empty($parentPage)) {
            $pos = strpos($this->request->page->structure_id, $parentPage->structure_id);
            if ($pos) {
                $this->message = __('structure::validation.page_cannot_be_parent') . ": {$this->request->page->structure_id} : {$parentPage->structure_id}";
            }
        } else {
            $this->message = __('structure::validation.parent_page_not_found');
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
