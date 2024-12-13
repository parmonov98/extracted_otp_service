<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SMSProvidersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('sms_providers')->insert([
            'name' => 'Eskiz',
            'login' => config('custom.eskiz_login'),
            'password' => encrypt(config('custom.eskiz_password')),
        ]);
    }
}
