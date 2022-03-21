<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerBalance extends Model
{
    protected $connection = 'sqlsrv';
    protected $table = 'YIVW_PrePaymentBalance';
    
    use HasFactory;

    protected $fillable = [
        'CustomerCD',
        'CustomerName',
        'TransferAmount',
        'Payment',
        'Balance',
    ];

}
