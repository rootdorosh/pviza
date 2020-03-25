<?php
declare( strict_types = 1 );

namespace App\Modules\User\Http\Requests\User;

use App\Base\Requests\BaseFormRequest;

/**
 * Class FormRequest
 * 
 * @package App\Modules\User
 *
 * @bodyParam name          string   required name.
 * @bodyParam email         string   required email.
 * @bodyParam is_active     integer  required active.
 * @bodyParam password      string   optional password (required only create action)
 * @bodyParam image_file    file     optional user photo
 * @bodyParam position      string   optional user position
 * @bodyParam roles         array    optional roles.
 * @bodyParam roles.*       integer  optional roles item.
 * @bodyParam events         array   optional events.
 * @bodyParam events.*      integer  optional events item.
 */
class FormRequest extends BaseFormRequest
{
    /*
     * @return bool
     */
    public function authorize(): bool
    {
        $action = empty($this->user) ? 'store' : 'update';
        
        return $this->user()->hasPermission('user.user.' . $action);
    }
    
    /**
     * @return array
     */
    public function rules(): array
    {
        $rules = [
            'email' => [
                'required',
                'string',
                'email',
                !empty($this->user) ? 'unique:users,id,' . $this->user->id : 'unique:users',
            ],           
            'name' => [
                'required',
                'string',
            ],           
            'password' => [
                !empty($this->user) ? 'nullable' : 'required',
                'string',
                'min:8',
                'max:20',
            ],
            'is_active' => [
                'required',
                'integer',
                'in:0,1',
            ],                       
            'position' => [
                'nullable',
                'string',
            ],                       
            'image_file' => [
                'nullable',
                'mimes:jpeg,jpg,png',
                'max:' . (1024 * 5), // 5MB
            ],                       
            'roles' => [
                'nullable',
                'array',
            ],
            'roles.*' => [
                'integer',
                'exists:users_roles,id',
            ],
            'events' => [
                'nullable',
                'array',
            ],
            'events.*' => [
                'integer',
                'exists:event,id',
            ],
        ];
                
        return $rules;
    }
    
    /*
     * @return array
     */
    public function attributes(): array
    {
        return $this->getAttributesLabels('User', 'User');
    }
}
