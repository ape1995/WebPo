<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerDetail extends Model
{
    protected $connection = 'sqlsrv';
    protected $table = 'Customer';
    
    use HasFactory;

    protected $fillable = [
        'BAccountID',
        'CustomerClassID',
        'TermsID',
        'DefPaymentMethodID',
        'CuryID',
    ];

}
