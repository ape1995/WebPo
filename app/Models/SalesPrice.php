<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesPrice extends Model
{
    protected $connection = 'sqlsrv';
    protected $table = 'ARSalesPrice';
    
    use HasFactory;

    protected $fillable = [
        'RecordID',
        'PriceType',
        'CustPriceClassID',
        'CustomerID',
        'InventoryID',
        'CuryID',
        'UOM',
        'EffectiveDate',
        'ExpirationDate',
        'SalesPrice',
    ];

}
