<?php

declare(strict_types=1);

namespace App\Services\OtpService;

use App\Services\OtpService\Contract\OtpSendInterface;
use Log;

class LocalOtpService implements OtpSendInterface
{
    public function sendOtp(int $otp, string $attribute): void
    {
        Log::info("OTP for $attribute : $otp");
    }
}
