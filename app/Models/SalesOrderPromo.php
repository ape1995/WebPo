<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class SalesOrderPromo
 * @package App\Models
 * @version June 17, 2022, 10:31 am WIB
 *
 * @property string $order_nbr
 * @property string $customer_id
 * @property string $order_date
 * @property string $delivery_date
 * @property integer $order_qty
 * @property number $order_amount
 * @property number $tax
 * @property number $order_total
 * @property string $description
 * @property string $status
 * @property integer $created_by
 * @property integer $updapted_by
 * @property integer $canceled_by
 * @property string $canceled_at
 * @property integer $submitted_by
 * @property string $submitted_at
 * @property integer $rejected_by
 * @property string $rejected_at
 * @property string $rejected_reason
 * @property integer $processed_by
 * @property string $processed_at
 * @property string $order_type
 */
class SalesOrderPromo extends Model
{
   
    use HasFactory;

    public $table = 'sales_order_promos';
    

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
        'updapted_by',
        'canceled_by',
        'canceled_at',
        'submitted_by',
        'submitted_at',
        'rejected_by',
        'rejected_at',
        'rejected_reason',
        'processed_by',
        'processed_at',
        'order_type'
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
        'order_amount' => 'double',
        'tax' => 'double',
        'order_total' => 'double',
        'description' => 'string',
        'status' => 'string',
        'created_by' => 'integer',
        'updapted_by' => 'integer',
        'canceled_by' => 'integer',
        'canceled_at' => 'date',
        'submitted_by' => 'integer',
        'submitted_at' => 'date',
        'rejected_by' => 'integer',
        'rejected_at' => 'date',
        'rejected_reason' => 'string',
        'processed_by' => 'integer',
        'processed_at' => 'date',
        'order_type' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
