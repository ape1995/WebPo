<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use App\Mail\SendMailCShipmentNInvoiced;
use App\Exports\CshipmentNInvoiced;
use App\Models\MailSetting;
use App\Models\SalesOrder;
use Illuminate\Support\Facades\Storage;
use Auth;
use DB;
use Excel;

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
            $url = url("/salesOrders-Filter?status=R&sort=created_at,desc");
            $data = [
                'title' => 'Ada order pending! Yuk lihat',
                'pending' => $totalUnprocess,
                'url' => $url,
            ];
            Mail::to($email)->cc($cc)->bcc($bcc)->send(new SendMail($data));
            return 'Berhasil mengirim email!';
        }

        // return view('email.email_1', compact('data'));
    }

    public function sendNotifConfirmShipmentNotInvoiced()
    {
        $mailTo = MailSetting::where('name', 'Confirm Shipment Not Invoiced')->where('type', 'Receiver')->where('sub_type', 'To')->where('status', 1)->pluck('email');
        $mailCC = MailSetting::where('name', 'Confirm Shipment Not Invoiced')->where('type', 'Receiver')->where('sub_type', 'CC')->where('status', 1)->pluck('email');
        $mailBCC = MailSetting::where('name', 'Confirm Shipment Not Invoiced')->where('type', 'Receiver')->where('sub_type', 'BCC')->where('status', 1)->pluck('email');
    
        $notInvoiced = DB::connection('sqlsrv')->select("SELECT * FROM YIVW_ConfirmShipmentNotInvoice");
        
        $date = date('Y-m-d');
        // dd($notInvoiced);
        Excel::store(new CshipmentNInvoiced($notInvoiced), 'Confirm Shipment Not Invoiced '.$date.'.xlsx', 'local');

        $fileName = 'Confirm Shipment Not Invoiced '.$date.'.xlsx';
        
        $email = $mailTo;
        $cc = $mailCC;
        $bcc = $mailBCC;
        Mail::to($email)->cc($cc)->bcc($bcc)->send(new SendMailCShipmentNInvoiced($notInvoiced, $fileName));
        
        // Mail::to($email)->cc($cc)->bcc($bcc)->send('email.confirm_shipment_not_invoiced', $data, function($message)use($data, $attechfiles) {
        //     $message->to($data["email"], $data["email"])
        //                 ->subject($data["title"]);
        //     $message->attach($file);
        // });
    }
}