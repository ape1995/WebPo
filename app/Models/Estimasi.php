<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estimasi extends Model
{
    protected $connection = 'sqlsrv';
    protected $table = 'xkidSODetail';
    public $timestamps = false;
    use HasFactory;

    protected $fillable = [
        'CompanyID',
        'BranchID',
        'OrderType',
        'OrderNbr',
        'CustomerID',
        'OutletID',
        'RitID',
        'InventoryID',
        'OrderQty',
        'RequestDate',
        'ShippedQty',
        'ShippedDate',
        'CreatedDateTime',
        'CreatedByID',
        'CreatedByScreenID',
        'LastModifiedDateTime',
        'LastModifiedByID',
        'LastModifiedByScreenID',
        'tstamp',
        'filename',
        'CustomerPONbr',
        'Shipping',
        'ShipmentConfirmed',
        'InvoiceNbr',
        'ShipmentNbr',
        'InvoiceFileName',
        'ConfirmSeqNbr',
        'ConfirmDocNbr',
        'AdjQty',
        'FinalQty',
    ];

    public function product()
    {
        return $this->hasOne(Product::class, 'InventoryID', 'InventoryID');
    }

}
