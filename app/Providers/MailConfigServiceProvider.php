<?php

namespace App\Providers;

use Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use App\Models\MailSetting;

class MailConfigServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        if (\Schema::hasTable('mail_settings')) {
            // dd('test');
            // $mail = MailSetting::where('type', 'Sender')->where('status', 1)->get()->first();
            $mail = DB::connection('pgsql')->select('SELECT * FROM mail_settings where type = '."'Sender'".' AND status = true');
            // dd($mail[0]);
            if ($mail) //checking if table is not empty
            {
                $config = array(
                    'driver'     => env('MAIL_MAILER'),
                    'host'       => env('MAIL_HOST'),
                    'port'       => env('MAIL_PORT'),
                    'from'       => array('address' => $mail[0]->email, 'name' => env('MAIL_FROM_NAME')),
                    'encryption' => env('MAIL_ENCRYPTION'),
                    'username'   => $mail[0]->email,
                    'password'   => $mail[0]->password,
                    'sendmail'   => '/usr/sbin/sendmail -bs',
                    'pretend'    => false,
                    'timeout' => null,
                    'auth_mode' => null,
                    'stream' => [
                        'ssl' => [
                            'allow_self_signed' => true,
                            'verify_peer' => false,
                            'verify_peer_name' => false,
                        ],
                    ],
                );
                Config::set('mail', $config);
            }
        }
    }
}