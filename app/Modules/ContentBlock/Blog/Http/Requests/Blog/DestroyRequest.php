<?php 

declare( strict_types = 1 );

namespace App\Modules\Blog\Http\Requests\Blog;

use App\Base\Requests\BaseDestroyRequest;

/**
 * Class DestroyRequest
 */
class DestroyRequest extends BaseDestroyRequest
{
    /*
     * @return  bool
     */
    public function authorize(): bool
    {
        return $this->user()->hasPermission('blog.blog.destroy');
    }
}
