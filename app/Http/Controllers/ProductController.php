<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\CustomerProduct;
use App\Exports\FProductExport;
use Auth;

class ProductController extends Controller
{
    
    public function downloadFormat(){
        
        // $products = Product::select('InventoryCD', 'Descr')->whereRaw("LEFT(InventoryCD, 2) = 'FG' AND ItemStatus = 'AC'")->whereNotIn('InventoryCD', ['FG001011','FG007001','FG008004','FG008005','FG009001', 'FG010005', 'FG011004', 'FG001008', 'FG002013', 'FG008001', 'FG008002', 'FG007009', 'FG002021'])->orderBy('InventoryCD', 'ASC')->get();

        $products = CustomerProduct::where('customer_code', Auth::user()->customer->AcctCD)->get();
        // dd($products);

        return Excel::download(new FProductExport($products), "Format Import Product.xlsx");
    
    }

}
