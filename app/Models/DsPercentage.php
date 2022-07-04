<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class DsPercentage
 * @package App\Models
 * @version June 7, 2022, 8:19 am WIB
 *
 * @property string $start_date
 * @property string $end_date
 * @property integer $percentage
 */
class DsPercentage extends Model
{

    use HasFactory;

    public $table = 'ds_percentages';
    



    public $fillable = [
        'start_date',
        'end_date',
        'customer_code',
        'percentage'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'percentage' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    public function customer()
    {
        return $this->hasOne(Customer::class, 'AcctCD', 'customer_code');
    }

    
}
