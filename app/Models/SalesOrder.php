<?php

namespace App\Models;

use Eloquent as Model;
// use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class SalesOrder
 * @package App\Models
 * @version January 10, 2022, 3:20 am UTC
 *
 * @property string $order_nbr
 * @property string $customer_id
 * @property string $order_date
 * @property string $delivery_date
 * @property integer $order_qty
 * @property integer $tax
 * @property string $description
 * @property string $created_by
 * @property string $updated_by
 */
class SalesOrder extends Model
{
    // use SoftDeletes;

    use HasFactory;

    public $table = 'sales_orders';
    

    // protected $dates = ['deleted_at'];



    public $fillable = [
        'order_nbr',
        'customer_id',
        'order_date',
        'delivery_date',
        'order_qty',
        'order_amount',
        'tax',
        'order_total',
        'description',
        'status',
        'created_by',
        'updated_by'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'order_nbr' => 'string',
        'customer_id' => 'string',
        'order_date' => 'date',
        'delivery_date' => 'date',
        'order_qty' => 'integer',
        'tax' => 'integer',
        'description' => 'string',
        'status' => 'string',
        'created_by' => 'string',
        'updated_by' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'order_nbr' => 'required',
        'customer_id' => 'required',
        'order_date' => 'required',
        'delivery_date' => 'required',
        'order_qty' => 'order_amount integer number',
        'tax' => 'order_total integer number'
    ];


    public function createdBy()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }
    
    public function updatedBy()
    {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }
    
    public function customer()
    {
        return $this->hasOne(Customer::class, 'BAccountID', 'customer_id');
    }
}
