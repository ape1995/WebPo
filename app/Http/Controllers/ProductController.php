<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Exports\FProductExport;

class ProductController extends Controller
{
    
    public function downloadFormat(){
        
        $products = Product::select('InventoryCD', 'Descr')->whereRaw("LEFT(InventoryCD, 2) = 'FG' AND ItemStatus = 'AC'")->whereNotIn('InventoryCD', ['FG001011','FG007001','FG008004','FG008005','FG009001', 'FG010005', 'FG011004'])->orderBy('InventoryCD', 'ASC')->get();

        // dd($products);

        return Excel::download(new FProductExport($products), "Format Import Product.xlsx");
    
    }

}