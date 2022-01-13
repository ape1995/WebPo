<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $connection = 'sqlsrv';
    protected $table = 'Location';
    
    use HasFactory;

    protected $fillable = [
        'BAccountID',
        'LocationID',
        'LocationCD',
        'Descr',
        'DefAddressID',
        'DefContactID',
        'TaxRegistrationID',
        'IsActive',
        'CSalesAcctID',
        'CSalesSubID',
        'CPriceClassID', // ini Price Class Customer
    ];

}
