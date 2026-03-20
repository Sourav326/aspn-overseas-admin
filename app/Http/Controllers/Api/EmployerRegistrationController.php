<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\EmployerRegistrationRequest;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class EmployerRegistrationController extends Controller
{
    /**
     * Register a new employer/client
     */
    public function register(EmployerRegistrationRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            // 1. Create user account
            $user = $this->createUser($request);

            // 2. Create client profile
            $client = $this->createClient($request, $user);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Registration successful! We will verify your organization details.',
                'data' => [
                    'client_id' => $client->client_id,
                    'name' => $client->name,
                    'organization_name' => $client->organization_name,
                    'email' => $client->email,
                    'phone' => $client->phone,
                    'industry_type' => $client->industry_type,
                    'status' => $client->status,
                    'registered_at' => $client->registered_at->toISOString(),
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
                'name' => $request->name,
                'username' => $username,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make(Str::random(16)), // Random password
                'is_active' => true,
            ]);

            // Assign client role
            $clientRole = Role::firstOrCreate(['name' => 'client']);
            $user->assignRole($clientRole);
        }

        return $user;
    }

    /**
     * Create client profile
     */
    private function createClient($request, $user): Client
    {
        return Client::create([
            'name' => $request->name,
            'organization_name' => $request->organization_name,
            'phone' => $request->phone,
            'whatsapp_number' => $request->whatsapp_number,
            'email' => $request->email,
            'industry_type' => $request->industry_type,
            'status' => 'pending',
            'verification_status' => 'pending',
            'registered_from_ip' => $request->ip(),
            'registered_from_device' => $request->userAgent(),
            'user_id' => $user->id,
        ]);
    }
}