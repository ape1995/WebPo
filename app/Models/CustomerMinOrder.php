<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class CustomerMinOrder
 * @package App\Models
 * @version March 10, 2022, 10:18 am WIB
 *
 * @property string $customer_code
 * @property integer $minimum_order
 */
class CustomerMinOrder extends Model
{

    use HasFactory;

    public $table = 'customer_min_orders';
    



    public $fillable = [
        'customer_code',
        'minimum_order'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'customer_code' => 'string',
        'minimum_order' => 'integer'
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
