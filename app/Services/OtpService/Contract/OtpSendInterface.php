<?php

namespace App\Services\OtpService\Contract;

interface OtpSendInterface
{
    public function sendOtp(int $otp, string $attribute): void;
}
