<?php

namespace App\Exports;

use App\Invoice;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ReportBalanceExport implements FromView, ShouldAutoSize
{

    protected $prePayments;
    protected $customerCode;
    protected $customerName;
    protected $balance;

    public function __construct($prePayments, $customerCode, $customerName, $balance )
    {
        $this->prePayments = $prePayments;
        $this->customerCode = $customerCode;
        $this->customerName = $customerName;
        $this->balance = $balance;
    }

    public function view(): View
    {       
        $prePayments = $this->prePayments;
        $customerCode = $this->customerCode;
        $customerName = $this->customerName;
        $balance = $this->balance;

        return view('exports.balance',compact('prePayments', 'customerCode', 'customerName', 'balance'));
    }

}
