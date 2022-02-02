<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SOOrder extends Model
{
    protected $connection = 'sqlsrv';
    protected $table = 'SOOrder';
    
    use HasFactory;

    protected $fillable = [
        'OrderType',
        'OrderNbr',
        'OrderTotal',
        'OrderQty',
    ];

}
