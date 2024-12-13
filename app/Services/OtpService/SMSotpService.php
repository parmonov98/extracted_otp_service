<?php

namespace App\Services\OtpService;

use App\Services\OtpService\Contract\OtpSendInterface;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Request;

class SMSotpService implements OtpSendInterface
{
    /**
     * @throws Exception
     */
    public function sendOtp(int $otp, string $attribute): void
    {
        $key = $this->throttleKey($attribute);

        // TODO
        //        if (app()->environment() === 'production') {
        //            if (RateLimiter::tooManyAttempts($key, 5)) {
        //                throw new Exception("Too many requests sent. Please try again later.");
        //            }
        //        }

        RateLimiter::hit($key, 10 * 60);

        $data = [
            'mobile_phone' => $attribute,
            'message' => __('messages.otp_sms')."$otp",
            'from' => 4546,
        ];
        Log::log('INFO', "OTP for $attribute : ".$otp);

        $token = DB::table('sms_providers')->where('name', 'Eskiz')->first()->token;
        $token = decrypt($token);

        try {
            $res = Http::withHeaders(['Authorization' => 'Bearer '.$token])->post('notify.eskiz.uz/api/message/sms/send', $data);
            $data = $res->json();

            if (isset($data['status']) && $data['status'] !== 'waiting') {
                throw new Exception($data['message']);
            }

        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    protected function throttleKey($attribute)
    {
        return $attribute.'|'.Request::ip();
    }
}
