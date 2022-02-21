<?php

namespace App\Exports;

use App\Product;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class FProductExport implements FromView, ShouldAutoSize
{
    
    protected $products;

    public function __construct($products)
    {
        $this->products = $products;
    }

    public function view(): View
    {       
        $products = $this->products;

        return view('exports.format_product',compact('products'));
    }
}
