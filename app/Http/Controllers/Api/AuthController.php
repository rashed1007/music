<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\SendOtpRequest;
use App\Http\Requests\Auth\VerifyOtpRequest;
use App\Http\Requests\User\UpdateCarShowProfileRequest;
use App\Http\Resources\User\EditCarShowProfile;
use App\Interfaces\AuthApiInterface;
use App\Traits\ApiResponseTrait;



class AuthController extends Controller
{
    use ApiResponseTrait;


    protected AuthApiInterface $authService;

    public function __construct(AuthApiInterface $authService)
    {
        $this->authService = $authService;
    }




    public function sendOtp(SendOtpRequest $request)
    {
        $otp =  $this->authService->sendOtp($request->phone);



        return $this->apiResonseForMobile(
            1,
            'OTP sent successfully',
            [
                'otp'   => $otp,
            ],
        );
    }

    public function verifyOtp(VerifyOtpRequest $request)
    {
        $data = $this->authService->verifyOtp(
            $request->phone,
            $request->otp
        );



        return $this->apiResonseForMobile(
            1,
            'Logged in successfully',
            [
                'token'   => $data['token'],
                'user'   => $data['user'],
            ],
        );
    }


    public function register(RegisterRequest $request)
    {
        $user = $this->authService->register($request->validated());

        return $this->apiResonseForMobile(
            1,
            'Registered successfully',
            [
                'user'   => $user,
            ],
        );
    }



    public function logout()
    {
        $this->authService->logout();

        return $this->apiResonseForMobile(
            1,
            'Logged out successfully'
        );
    }
}
