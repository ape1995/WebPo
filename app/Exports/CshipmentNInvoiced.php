<?php

namespace App\Exports;

use App\Product;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CshipmentNInvoiced implements FromView, ShouldAutoSize
{
    
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function view(): View
    {       
        $data = $this->data;

        return view('exports.confirm_shipment_not_invoiced',compact('data'));
    }
}
