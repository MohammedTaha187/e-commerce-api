<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function redirectToGoogle()
{
    return Socialite::driver('google')->stateless()->redirect();

}


public function handleGoogleCallback()
{
    try {
        $user = Socialite::driver('google')->stateless()->user();

        if (!$user || !$user->getEmail()) {
            return response()->json(['error' => 'Google login failed'], 400);
        }

        // البحث عن المستخدم أو تحديث بياناته
        $user = User::updateOrCreate(
            ['email' => $user->getEmail()],
            [
                'name' => $user->getName(),
                'password' => Hash::make(uniqid()), // كلمة مرور عشوائية للمستخدمين الجدد
                'image' => $user->getAvatar(),
                'email_verified_at' => now(),
                'social_id' => $user->getId(),
                'social_type' => 'google',
            ]
        );

        // إنشاء توكن للمستخدم
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'User logged in successfully',
            'token' => $token,
            'user' => $user,
        ], 200);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Something went wrong! ' . $e->getMessage()], 500);
    }
}


}
