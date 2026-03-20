<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CandidateRegistrationRequest;
use App\Models\Candidate;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class CandidateRegistrationController extends Controller
{
    /**
     * Register a new candidate from Next.js portal
     * Fields: first_name, last_name, phone, whatsapp_number, email, 
     *         passport_number, indian_experience_years, overseas_experience_years,
     *         trade_name, industry_type, resume (file)
     */
    public function register(CandidateRegistrationRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            // 1. Create user account
            $user = $this->createUser($request);

            // 2. Upload resume
            $resumeData = $this->uploadResume($request);

            // 3. Create candidate profile with all fields
            $candidate = $this->createCandidate($request, $user, $resumeData);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Registration successful! Your application has been submitted.',
                'data' => [
                    'candidate_id' => $candidate->candidate_id,
                    'full_name' => $candidate->full_name,
                    'first_name' => $candidate->first_name,
                    'last_name' => $candidate->last_name,
                    'email' => $candidate->email,
                    'phone' => $candidate->phone,
                    'whatsapp_number' => $candidate->whatsapp_number,
                    'passport_number' => $candidate->passport_number,
                    'indian_experience_years' => $candidate->indian_experience_years,
                    'overseas_experience_years' => $candidate->overseas_experience_years,
                    'trade_name' => $candidate->trade_name,
                    'industry_type' => $candidate->industry_type,
                    'resume_url' => $candidate->resume_url,
                    'status' => $candidate->status,
                    'registered_at' => $candidate->registered_at->toISOString(),
                ]
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Registration failed. Please try again.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Check registration status by email
     */
    public function checkStatus(string $email): JsonResponse
    {
        $candidate = Candidate::where('email', $email)->first();
        
        if (!$candidate) {
            return response()->json([
                'success' => false,
                'message' => 'Candidate not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'candidate_id' => $candidate->candidate_id,
                'full_name' => $candidate->full_name,
                'email' => $candidate->email,
                'phone' => $candidate->phone,
                'whatsapp_number' => $candidate->whatsapp_number,
                'passport_number' => $candidate->passport_number,
                'indian_experience_years' => $candidate->indian_experience_years,
                'overseas_experience_years' => $candidate->overseas_experience_years,
                'trade_name' => $candidate->trade_name,
                'industry_type' => $candidate->industry_type,
                'status' => $candidate->status,
                'registered_at' => $candidate->registered_at->toISOString(),
            ]
        ]);
    }

    /**
     * Create user account
     */
    private function createUser($request): User
    {
        // Check if user already exists
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            // Generate username from email
            $username = explode('@', $request->email)[0];
            $originalUsername = $username;
            $counter = 1;
            
            while (User::where('username', $username)->exists()) {
                $username = $originalUsername . $counter;
                $counter++;
            }

            // Create new user
            $user = User::create([
                'name' => $request->first_name . ' ' . $request->last_name,
                'username' => $username,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make(Str::random(16)), // Random password
                'is_active' => true,
            ]);

            // Assign candidate role
            $candidateRole = Role::firstOrCreate(['name' => 'candidate']);
            $user->assignRole($candidateRole);
        }

        return $user;
    }

    /**
     * Upload resume file
     */
    private function uploadResume($request): array
    {
        if ($request->hasFile('resume')) {
            $file = $request->file('resume');
            $originalName = $file->getClientOriginalName();
            $fileName = time() . '_' . Str::slug(pathinfo($originalName, PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            
            $path = $file->storeAs('candidates/resumes', $fileName, 'public');
            
            return [
                'path' => $path,
                'original_name' => $originalName,
                'size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
            ];
        }
        
        return [];
    }

    /**
     * Create candidate profile with all fields
     */
    private function createCandidate($request, $user, $resumeData): Candidate
    {
        $candidateData = [
            // Personal Information
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'whatsapp_number' => $request->whatsapp_number,
            'email' => $request->email,
            'passport_number' => $request->passport_number,
            
            // Experience
            'indian_experience_years' => $request->indian_experience_years ?? 0,
            'overseas_experience_years' => $request->overseas_experience_years ?? 0,
            
            // Professional Information
            'trade_name' => $request->trade_name,
            'industry_type' => $request->industry_type,
            
            // Resume
            'resume_path' => $resumeData['path'] ?? null,
            'resume_original_name' => $resumeData['original_name'] ?? null,
            'resume_size' => $resumeData['size'] ?? null,
            'resume_mime_type' => $resumeData['mime_type'] ?? null,
            
            // Status
            'status' => 'pending',
            
            // Tracking
            'registered_from_ip' => $request->ip(),
            'registered_from_device' => $request->userAgent(),
            'user_id' => $user->id,
        ];
        
        return Candidate::create($candidateData);
    }
}