<?php

declare(strict_types=1);

namespace App\Services\OtpService;

use App\Mail\OtpMail;
use App\Services\OtpService\Contract\OtpSendInterface;
use Illuminate\Support\Facades\Mail;

class MailOtpService implements OtpSendInterface
{
    public function sendOtp(int $otp, string $attribute): void
    {
        Mail::to($attribute)->send(new OtpMail($otp));
    }
}
