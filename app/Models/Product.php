<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $connection = 'sqlsrv';
    protected $table = 'InventoryItem';
    
    use HasFactory;

    protected $fillable = [
        'InventoryID',
        'InventoryCD',
        'Descr',
        'ItemType',
        'ItemStatus',
        'Status',
        'SalesUnit',
        'BasePrice',
    ];

}
