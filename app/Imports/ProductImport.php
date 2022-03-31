<?php

namespace App\Imports;

use App\Models\Cart;
use App\Models\Customer;
use App\Models\Location;
use App\Models\Product;
use App\Models\CustomerProduct;
use App\Models\SalesPrice;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Hash;
use Flash;
use Response;

class ProductImport implements ToCollection, WithHeadingRow
{
    public $date;

    public function  __construct($date)
    {
        $this->date= $date;
        $carts = Cart::where('customer_id', \Auth::user()->customer_id)->delete();
    }

    public function getCPriceClass($id){

        $location = Location::where('BAccountID', $id)->get()->first();
        $priceClass = $location->CPriceClassID;

        return $priceClass;

    }

    public function getInventoryID($id){
        $product = Product::where('InventoryCD', $id)->get()->first();

        return $product;
    }

    public function collection(Collection $rows)
    {

        foreach ($rows as $index => $row) 
        { 
            
            $kode_produk = $row['kode_produk'];
            

            // Cek ID Product Exist for this customer
            $cek_produk = CustomerProduct::where('customer_code',  \Auth::user()->customer->AcctCD)->where('inventory_code', $kode_produk)->get()->first();
            $errors = [];
            if($cek_produk == null){
                $errors[] = 'error';
                return $errors;
            }


        }

        foreach ($rows as $row) {
            
            $customer = \Auth::user()->customer_id;

            $priceClass = $this->getCPriceClass($customer);
            $inventory = $this->getInventoryID($row['kode_produk']);
            $inventoryID = $inventory->InventoryID;
            $salesPrice = SalesPrice::whereRaw("CustPriceClassID = '$priceClass' AND InventoryID = '$inventoryID' AND EffectiveDate <= '$this->date' AND (ExpirationDate IS NULL OR ExpirationDate >= '$this->date')")->get()->first();
            
            if($row['quantity'] > 0 || $row['quantity'] != null){
                Cart::create([
                    'inventory_id' => $row['kode_produk'],
                    'inventory_name' => $inventory->Descr,
                    'qty' => $row['quantity'],
                    'uom' => $salesPrice->UOM,
                    'unit_price' => $salesPrice->SalesPrice,
                    'amount' => $salesPrice->SalesPrice * $row['quantity'],
                    'customer_id' => $customer,
                    'created_by' => \Auth::user()->id,
                ]); 
            }
        }

    }

    public function headingRow(): int
    {
        return 1;
    }
}
