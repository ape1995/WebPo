<?php

namespace App\Imports;

use App\Models\Customer;
use App\Models\Product;
use App\Models\CustomerProduct;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Hash;
use Flash;

class CustomerProductImport implements ToCollection, WithHeadingRow
{

    public function collection(Collection $rows)
    {

        foreach ($rows as $index => $row) 
        { 
            // cek customer code
            $cekCustomer = Customer::where('AcctCD', $row['customer_code'])->get();
            if ($cekCustomer->count() == 0) {
                return redirect()->route('customerProducts.index')->with('error', 'customer '.$row['customer_code'].' - '.$row['customer_name']. ' tidak ditemukan!');
            }

            // cek produk
            $cekProduct = Product::where('InventoryCD', $row['inventory_code'])->get();
            if ($cekProduct->count() == 0) {
                return redirect()->route('customerProducts.index')->with('error', 'produk '.$row['inventory_code'].' tidak ada atau tidak active!');
            }


        }

        foreach ($rows as $row) {

            // cek email existing
            $cekProduct = Product::where('InventoryCD', $row['inventory_code'])->where('ItemStatus', 'AC')->get();
            if ($cekProduct->count() > 0) {

                $customer = Customer::where('AcctCD', $row['customer_code'])->get()->first();

                $cekInsertedProduct = CustomerProduct::where('inventory_code', $row['inventory_code'])->where('customer_code', $row['customer_code'])->get();

                if($cekInsertedProduct == null || $cekInsertedProduct->count() == 0){
                    $customerProduct = CustomerProduct::create([
                        'customer_code'  => $row['customer_code'],
                        'inventory_code' => $row['inventory_code'],
                        'customer_class' => $customer->customer2->CustomerClassID,
                    ]);
                }
            }



        }

        Flash::success('Import Data successfully.');

    }

    public function headingRow(): int
    {
        return 1;
    }
}
