<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class UpdateSMSProviderTokens extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:sms_provider_tokens';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update sms provider tokens. Currently only Eskiz provider is supported';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $eskiz = DB::table('sms_providers')->where('name', 'Eskiz')->first();

        if (! $eskiz) {
            throw new \Exception('No eskiz provider found');
        }

        $data = [
            'email' => $eskiz->login,
            'password' => decrypt($eskiz->password),
        ];

        try {
            $res = Http::asForm()->post('notify.eskiz.uz/api/auth/login', $data);

            $tokenData = $res->json();

            $token = $tokenData['data']['token'];

            DB::table('sms_providers')
                ->where('name', 'Eskiz')
                ->update([
                    'token' => encrypt($token),
                ]);
        } catch (\Exception $exception) {
            dd($exception);
        }

        print_r("TOKENS_RETRIEVED\n");

        return true;
    }
}
