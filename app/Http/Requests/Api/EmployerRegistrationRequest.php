<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class EmployerRegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Public endpoint
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'organization_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:clients,phone',
            'whatsapp_number' => 'nullable|string|max:20',
            'email' => 'required|email|max:255|unique:clients,email',
            'industry_type' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Name is required',
            'organization_name.required' => 'Organization name is required',
            'phone.required' => 'Phone number is required',
            'phone.unique' => 'This phone number is already registered',
            'email.required' => 'Email address is required',
            'email.unique' => 'This email is already registered',
            'email.email' => 'Please provide a valid email address',
            'industry_type.required' => 'Industry type is required',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}