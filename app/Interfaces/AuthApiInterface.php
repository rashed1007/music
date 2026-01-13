<?php

namespace App\Interfaces;


interface AuthApiInterface
{
    public function sendOtp(string $phone);

    public function verifyOtp(string $phone, string $otp);

    public function register(array $data);

    public function logout(): void;

}
