<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class CustomerFirstOrder
 * @package App\Models
 * @version October 21, 2022, 4:52 pm WIB
 *
 * @property string $customer_code
 * @property string $first_order_number
 * @property string $first_order_date
 * @property integer $created_by
 * @property integer $updated_by
 */
class CustomerFirstOrder extends Model
{

    use HasFactory;

    public $table = 'customer_first_orders';


    public $fillable = [
        'customer_code',
        'first_order_number',
        'first_order_date',
        'created_by',
        'updated_by'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'customer_code' => 'string',
        'first_order_number' => 'string',
        'first_order_date' => 'date',
        'created_by' => 'integer',
        'updated_by' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'customer_code' => 'required'
    ];

    public function customer()
    {
        return $this->hasOne(Customer::class, 'AcctCD', 'customer_code');
    }

    
}
