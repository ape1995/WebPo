<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Hash;
use Flash;

class UsersImport implements ToCollection, WithHeadingRow
{

    public function collection(Collection $rows)
    {

        foreach ($rows as $index => $row) 
        { 
            // dd($row);
            // cek customer code
            $cekCustomer = Customer::where('AcctCD', $row['customer_code'])->get();
            if ($cekCustomer->count() == 0) {
                return redirect()->route('users.index')->with('error', 'customer '.$row['customer_code'].' - '.$row['customer_name']. ' tidak ditemukan!');
            }

            // cek email existing
            $cekUserEmail = User::where('email', $row['email'])->get();
            if ($cekUserEmail->count() !== 0) {
                return redirect()->route('users.index')->with('error', 'email '.$row['email'].' sudah ada!');
            }


        }

        foreach ($rows as $row) {

            // cek email existing
            $cekUserEmail = User::where('email', $row['email'])->get();
            if ($cekUserEmail->count() !== 0) {
                return redirect()->route('users.index')->with('error', 'email '.$row['email'].' sudah ada!');
            }

            $customer = Customer::where('AcctCD', $row['customer_code'])->get()->first();

            $user = User::create([
                'name'  => $row['name'],
                'email' => $row['email'],
                'role' => $row['role'],
                'status' => true,
                'customer_id' => $customer->BAccountID,
                'password' => Hash::make($row['password']),
            ]);

            $user->assignRole($row['role']);
        }

        Flash::success('Import Data successfully.');

    }

    public function headingRow(): int
    {
        return 1;
    }
}
