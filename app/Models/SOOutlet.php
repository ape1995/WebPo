<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SOOutlet extends Model
{
    protected $connection = 'sqlsrv';
    protected $table = 'xtsSOOutlet';
    
    use HasFactory;

    protected $fillable = [
        'CompanyID',
        'OutletID',
        'OutletName',
        'CustomerID',
        'RitID',
        'Category',
        'MaxOrderAmount',
        'CreatedByID',
        'CreatedByScreenID',
        'CreatedDateTime',
        'LastModifiedByID',
        'LastModifiedByScreenID',
        'LastModifiedDateTime',
        'UsrLoadNbr',
        'UsrRitNbr',
        'UsrIsActive',
        'CustomerCD',
    ];
}
