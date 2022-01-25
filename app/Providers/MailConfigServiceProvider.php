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

            $mail = DB::connection('pgsql')->select('SELECT * FROM mail_settings where type = '."'Sender'".' AND status = true');
            
            if ($mail) //checking if table is not empty
            {
                $config = array(
                    'driver'     => 'smtp',
                    'host'       => 'mail.yamazakimyroti.co.id',
                    'port'       => '587',
                    'from'       => array('address' => $mail[0]->email, 'name' => 'Yamazaki Indonesia'),
                    'encryption' => 'tls',
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