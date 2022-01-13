<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class SalesOrderDetail
 * @package App\Models
 * @version January 10, 2022, 3:24 am UTC
 *
 * @property int $sales_order_id
 * @property string $inventory_id
 * @property string $inventory_name
 * @property integer $qty
 * @property string $uom
 * @property integer $unit_price
 * @property integer $amount
 * @property string $created_by
 * @property string $updated_by
 */
class SalesOrderDetail extends Model
{
    // use SoftDeletes;

    use HasFactory;

    public $table = 'sales_order_details';
    

    // protected $dates = ['deleted_at'];



    public $fillable = [
        'sales_order_id',
        'inventory_id',
        'inventory_name',
        'qty',
        'uom',
        'unit_price',
        'amount',
        'created_by',
        'updated_by'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'inventory_id' => 'string',
        'inventory_name' => 'string',
        'qty' => 'integer',
        'uom' => 'string',
        'unit_price' => 'integer',
        'amount' => 'integer',
        'created_by' => 'string',
        'updated_by' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
