<?php

namespace App\Http\Requests\UserManagement;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
   /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        if(request()->isMethod('PUT')){
            return [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'max:255'],
                'password' => ['required', 'string', 'max:255'],
                'role_id.*' => ['required'],
                'image' => ['nullable','image','max:3048'],
                'username' => ['nullable'],
                'class_room_id' => ['nullable'],
                'date_of_birth' => ['nullable'],
                'phone_number' => ['nullable'],
                'name_parent' => ['nullable'],
                'email_parent' => ['nullable'],
            ];
        }else{
            return [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'max:255','unique:users'],
                'password' => ['required', 'string', 'max:255'],
                'role_id.*' => ['required'],
                'image' => ['nullable','image','max:3048'],
                'username' => ['nullable'],
                'class_room_id' => ['nullable'],
                'date_of_birth' => ['nullable'],
                'phone_number' => ['nullable'],
                'name_parent' => ['nullable'],
                'email_parent' => ['nullable'],
            ];
        }
    }

    protected function prepareForValidation(): void
    {
        if(!request()->isMethod('PUT')){
            $this->merge([
                'password' => bcrypt($this->password),
                'username' => !$this->username ? strtoupper($this->name) : $this->username
            ]);
        }else{
            $this->merge([
               'username' => !$this->username ? strtoupper($this->name) : $this->username
            ]);
        }
    }
}
