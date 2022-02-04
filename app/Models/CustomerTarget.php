<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerTarget extends Model
{
    protected $connection = 'sqlsrv';
    protected $table = 'YISalesTargetCustomer';
    
    use HasFactory;

    protected $fillable = [
        'CustomerID',
        'CustomerCD',
        'CustomerName',
        'Year',
        'January',
        'February',
        'March',
        'April',
        'May',
        'June',
        'July',
        'August',
        'September',
        'October',
        'November',
        'December',
    ];

}
