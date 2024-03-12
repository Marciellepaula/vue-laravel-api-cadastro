<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function logout(Request $request)
    {
        try {
            $user = $request->user();

            if ($user) {
                // Revoke the user's token
                $user->tokens()->delete();
                return response()->json([
                    'success' => true,
                    'message' => 'Logged out successfully.',
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated.',
                ], 401);
            }
        } catch (\Exception $e) {
            // Handle any exceptions
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while logging out.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
