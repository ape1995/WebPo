<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class DsPercentageExport implements FromView, ShouldAutoSize
{

    protected $dsPercentages;

    public function __construct($dsPercentages)
    {
        $this->dsPercentages = $dsPercentages;
    }

    public function view(): View
    {       
        $dsPercentages = $this->dsPercentages;

        return view('exports.ds_percentages',compact('dsPercentages'));
    }

}
