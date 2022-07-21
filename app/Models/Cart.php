<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Cart
 * @package App\Models
 * @version January 11, 2022, 1:35 am UTC
 *
 * @property string $inventory_id
 * @property string $inventory_name
 * @property integer $qty
 * @property string $uom
 * @property integer $unit_price
 * @property integer $amount
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $customer_id
 */
class Cart extends Model
{

    use HasFactory;

    public $table = 'carts';



    public $fillable = [
        'inventory_id',
        'inventory_name',
        'qty',
        'uom',
        'unit_price',
        'discount',
        'amount',
        'created_by',
        'updated_by',
        'packet_code',
        'customer_id'
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
        'created_by' => 'integer',
        'updated_by' => 'integer',
        'customer_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'inventory_id' => 'required',
        'inventory_name' => 'required',
        'qty' => 'required',
        'uom' => 'required'
    ];

    
}
