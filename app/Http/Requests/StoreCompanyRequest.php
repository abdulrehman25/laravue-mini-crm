<?php

namespace App\Http\Requests;

use App\Rules\MinImageDimensionsRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreCompanyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'email' => 'sometimes|email:rfc,dns',
            'logo' => ['nullable', 'image', new MinImageDimensionsRule(100, 100)],
            'website' => 'sometimes|url:http,https'
        ];
    }
}
