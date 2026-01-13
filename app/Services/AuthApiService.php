<?php

namespace App\Services;

use App\Interfaces\AuthApiInterface;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AuthApiService implements AuthApiInterface
{


    // send and resend otp
    public function sendOtp(string $phone)
    {
        $user = User::where('phone', $phone)->firstOrFail();

        $user->update([
            'otp' => rand(1000, 9999),
            'otp_expires_at' => now()->addMinutes(5),
        ]);

        //  SMS provider would be here

        return $user->otp;
    }

    public function verifyOtp(string $phone, string $otp)
    {
        $user = User::where('phone', $phone)
            ->where('otp', $otp)
            ->where('otp_expires_at', '>=', now())
            ->firstOrFail();

        $user->update([
            'otp' => null,
            'otp_expires_at' => null,
            'last_login' => now(),
            'phone_verified_at' => now(),
        ]);

        $token = $user->createToken('api-token')->plainTextToken;

        return [
            'token' => $token,
            'user'  => $user,
        ];
    }




    public function register(array $data)
    {

        return DB::transaction(function () use ($data) {

            $user = User::create($data);

            $user->update([
                'otp' => rand(1000, 9999),
                'otp_expires_at' => now()->addMinutes(5),
            ]);

            // logo
            $user
                ->addMedia($data['logo'])
                ->toMediaCollection('logo');


            return $user;
        });
    }


    public function logout(): void
    {
        $user = auth('sanctum')->user();

        if (!$user) {
            return;
        }

        // logout from current device only
        $user->currentAccessToken()?->delete();
    }
}
