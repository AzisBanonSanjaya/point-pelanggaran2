<?php

namespace App\Http\Requests\MasterData;

use Illuminate\Foundation\Http\FormRequest;
use Auth;
class CategoryRequest extends FormRequest
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
        return [
            'name' => 'required',
            'point' => 'required',
            'type' => 'required',
        ];
    }

    protected function prepareForValidation(): void
    {
        if(!request()->isMethod('PUT')){
            $this->merge([
                'created_by' => Auth::id(),
            ]);
        }else{
            $this->merge([
                'updated_by' => Auth::id(),

            ]);
        }
    }
}
