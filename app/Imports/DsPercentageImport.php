<?php

namespace App\Imports;

use App\Models\DsPercentage;
use App\Models\Customer;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Hash;
use Flash;

class DsPercentageImport implements ToCollection, WithHeadingRow
{

    public function collection(Collection $rows)
    {

        foreach ($rows as $row) {

            $cekCustomer = Customer::where('AcctCD', $row['customer_code'])->get();
            if ($cekCustomer->count() == 0) {
                return redirect()->route('dsRules.index')->with('error', 'customer '.$row['customer_code'].' tidak ditemukan!');
            }

        }

        foreach ($rows as $row) {
            
            DsPercentage::create([
                'customer_code'  => $row['customer_code'],
                'start_date' => $row['start_date'],
                'end_date' => $row['end_date'],
                'percentage' => $row['percentage'],
            ]);

        }

        Flash::success('Import Data successfully.');

    }

    public function headingRow(): int
    {
        return 1;
    }
}
