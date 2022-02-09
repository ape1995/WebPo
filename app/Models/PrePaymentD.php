<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrePaymentD extends Model
{
    protected $connection = 'sqlsrv';
    protected $table = 'xv_ARPreyPaymentDetail';
    
    use HasFactory;

    protected $fillable = [
        'AdjgRefNbr',
        'OrderNbr',
        'OrderDate',
        'OrderTotal',
        'AlocationPayment',
        'InvoicePayment',
        'TotalPayment',
    ];

}
