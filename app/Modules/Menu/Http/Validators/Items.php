<?php
declare( strict_types = 1 );

namespace App\Modules\Menu\Http\Validators;

use Illuminate\Contracts\Validation\Rule;
use App\Modules\Menu\Services\MenuService;
use App\Base\Requests\BaseFormRequest;
use App\Modules\Menu\Models\Item;

/**
 * Class Items
 * @package App\Modules\Menu
 */
class Items implements Rule
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
       // dd($value);
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
