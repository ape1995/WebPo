<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use App\Models\MailSetting;
use App\Models\SalesOrder;
use Auth;

class SendEmailController extends Controller
{
    public function send()
    {   
        $mailTo = MailSetting::where('name', 'Daily Notification')->where('type', 'Receiver')->where('sub_type', 'To')->where('status', 1)->pluck('email');
        $mailCC = MailSetting::where('name', 'Daily Notification')->where('type', 'Receiver')->where('sub_type', 'CC')->where('status', 1)->pluck('email');
        $mailBCC = MailSetting::where('name', 'Daily Notification')->where('type', 'Receiver')->where('sub_type', 'BCC')->where('status', 1)->pluck('email');
        
        $salesOrder = SalesOrder::where('status', 'R')->get();
        $totalUnprocess = $salesOrder->count('id');
        if($totalUnprocess == 0){
            return 'Email tidak dikirim karena pending order kosong!';
        } else {
            $email = $mailTo;
            $cc = $mailCC;
            $bcc = $mailBCC;
            $data = [
                'title' => 'Ada order pending! Yuk lihat',
                'pending' => $totalUnprocess,
                'url' => 'https://yamazakimyroti.co.id',
            ];
            Mail::to($email)->cc($cc)->bcc($bcc)->send(new SendMail($data));
            return 'Berhasil mengirim email!';
        }

        // return view('email.email_1', compact('data'));
    }
}