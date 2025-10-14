<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
            'company_code' => 'required|string',
        ]);

        $user = User::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'username' => ['The provided credentials are incorrect.'],
            ]);
        }

        if (!$user->is_active) {
            return response()->json([
                'error' => 'Your account is inactive. Please contact administrator.'
            ], 403);
        }

        $company = Company::where('code', $request->company_code)->first();
        
        if (!$company) {
            return response()->json([
                'error' => 'Invalid company selected.'
            ], 404);
        }

        if ($user->company_id !== $company->id) {
            return response()->json([
                'error' => 'You do not have access to this company.'
            ], 403);
        }

        $token = $user->createToken('web-token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
                'full_name' => $user->full_name,
                'company_id' => $user->company_id,
            ],
            'company' => [
                'id' => $company->id,
                'name' => $company->name,
                'code' => $company->code,
                'primary_color' => $company->primary_color,
                'accent_color' => $company->accent_color,
                'logo_url' => $company->logo_url,
            ],
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Successfully logged out.'
        ], 200);
    }

    public function user(Request $request)
    {
        return response()->json([
            'user' => $request->user(),
            'company' => $request->user()->company,
        ], 200);
    }
}