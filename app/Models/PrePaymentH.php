<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrePaymentH extends Model
{
    protected $connection = 'sqlsrv';
    protected $table = 'xv_ARPreyPaymentHeader';
    
    use HasFactory;

    protected $fillable = [
        'PrePaymentRefNbr',
        'CustomerCD',
        'CustomerName',
        'TransferAmount',
        'TransferDate',
        'FinPeriodID',
        'Descr',
        'Currency',
    ];

    public function detail()
    {
        return $this->hasMany(PrePaymentD::class, 'AdjgRefNbr', 'PrePaymentRefNbr');
    }

}
