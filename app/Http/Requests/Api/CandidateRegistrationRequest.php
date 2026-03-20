<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class CandidateRegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Public endpoint
    }

    public function rules(): array
    {
        return [
            // Personal Information
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'phone' => 'required|string|max:20|unique:candidates,phone',
            'whatsapp_number' => 'required|string|max:20',
            'email' => 'required|email|max:255|unique:candidates,email',
            'passport_number' => 'required|string|max:50|unique:candidates,passport_number',
            
            // Experience
            'indian_experience_years' => 'required|integer|min:0|max:50',
            'overseas_experience_years' => 'required|integer|min:0|max:50',
            
            // Professional Information
            'trade_name' => 'required|string|max:255',
            'industry_type' => 'required|string|max:255',
            
            // Resume File
            'resume' => 'required|file|mimes:pdf,doc,docx|max:5120', // 5MB
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required' => 'First name is required',
            'last_name.required' => 'Last name is required',
            
            'phone.required' => 'Phone number is required',
            'phone.unique' => 'This phone number is already registered',
            
            'email.required' => 'Email address is required',
            'email.unique' => 'This email is already registered',
            'email.email' => 'Please provide a valid email address',
            
            'passport_number.unique' => 'This passport number is already registered',
            
            'trade_name.required' => 'Trade/Profession name is required',
            'industry_type.required' => 'Industry type is required',
            
            'resume.required' => 'Resume file is required',
            'resume.mimes' => 'Resume must be a PDF or Word document (DOC, DOCX)',
            'resume.max' => 'Resume size must not exceed 5MB',
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