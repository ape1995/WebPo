<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $connection = 'sqlsrv';
    protected $table = 'BAccount';
    
    use HasFactory;

    protected $fillable = [
        'BAccountID',
        'AcctCD',
        'AcctName',
        'AcctReferenceNbr',
        'Type',
        'Status',
        'TaxZoneID',
        'DefContactID',
        'DefAddressID',
        'DefLocationID',
        'ConsolidatingBAcountID',
        'NoteID',
    ];

    public function location()
    {
        return $this->hasOne(Location::class, 'BAccountID', 'BAccountID');
    }

    public function detail()
    {
        return $this->hasOne(CustomerDetail::class, 'BAccountID', 'BAccountID');
    }

    public function outlet()
    {
        return $this->hasOne(SOOutlet::class, 'CustomerID', 'BAccountID')->where('UsrIsActive', true)->orderBy('CreatedDateTime', 'DESC');
    }

    public function customer2()
    {
        return $this->hasOne(Customer2::class, 'BAccountID', 'BAccountID');
    }

    public function category()
    {
        return $this->hasOne(CSAnswer::class, 'RefNoteID', 'NoteID')->where('AttributeID', 'CATEGORY');
    }

    public function delivery()
    {
        return $this->hasOne(CSAnswer::class, 'RefNoteID', 'NoteID')->where('AttributeID', 'DELIVERY');
    }

}
