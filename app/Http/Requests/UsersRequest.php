<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

// php artisan make:request UsersRequest - creating request for validation in user create, edit ...
// Use this in the controller function in store function for validation
class UsersRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // To test this firts, change false to true
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // Fill in the requirement of the field you want to validate
            'name' => 'required',
            'email' => 'required',
            'role_id' => 'required',
            'is_active' => 'required',
            'password' => 'required'
        ];
    }
}
