<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use App\Models\SalesOrder;
use Auth;

class SendEmailController extends Controller
{
    public function send()
    {

        $salesOrder = SalesOrder::where('status', 'R')->get();
        $totalUnprocess = $salesOrder->count('id');

        $email = 'apeganteng@gmail.com';
        $data = [
            'title' => 'Ada order pending! Yuk lihat',
            'pending' => $totalUnprocess,
            'url' => 'https://yamazakimyroti.co.id',
        ];
        Mail::to($email)->send(new SendMail($data));
        return 'Berhasil mengirim email!';

        // return view('email.email_1', compact('data'));
    }
}