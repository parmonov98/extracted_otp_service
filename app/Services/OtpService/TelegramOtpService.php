<?php

declare(strict_types=1);

namespace App\Services\OtpService;

use App\Services\OtpService\Contract\OtpSendInterface;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramOtpService implements OtpSendInterface
{
    /**
     * @throws TelegramSDKException
     */
    public function sendOtp(int $otp, string $attribute): void
    {
        Telegram::bot('mybot')->sendMessage([
            'chat_id' => config('custom.telegram_chat_id'),
            'text' => 'Phone number: '.$attribute."\nCode: ".$otp,
        ]);
    }
}
