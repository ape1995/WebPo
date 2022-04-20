<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMailCShipmentNInvoiced extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    public $fileName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $fileName)
    {
        $this->data = $data;
        $this->fileName = $fileName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        
        return $this->markdown('email.confirm_shipment_not_invoiced')
        ->subject('Notification Confirm Shipment Not Invoiced!')
        ->with('data', $this->data)
        ->attachFromStorage($this->fileName);
    }
}
