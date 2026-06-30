<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MemberRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();
        if (!$user->hasPermissionTo('register members')) {
            return false;
        }

        if ($user->hasRole('Super Admin')) {
            return true;
        }

        $companyId = $this->input('company_id');
        if (!$companyId) {
            return false;
        }

        if ($user->hasRole('Denomination Admin') && $user->denomination_id) {
            $company = \App\Models\Company::find($companyId);
            return $company && $company->battalion && $company->battalion->denomination_id === $user->denomination_id;
        }

        if ($user->hasRole('Battalion Commander') && $user->battalion_id) {
            $company = \App\Models\Company::find($companyId);
            return $company && $company->battalion_id === $user->battalion_id;
        }

        if (($user->hasRole('Company Captain') || $user->hasRole('Company Officer')) && $user->company_id) {
            return $companyId === $user->company_id;
        }

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['sometimes', 'required', 'email', 'unique:users,email'],
            'rank' => ['required', 'string', 'max:255'],
            'company_id' => ['required', 'exists:companies,id'],
            'tenure' => ['nullable', 'integer', 'min:0'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'registration_fee_paid' => ['sometimes', 'boolean'],
        ];
    }
    
    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'registration_fee_paid' => $this->has('registration_fee_paid'),
        ]);
    }
}
