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
        'packet_code',
        'inventory_name',
        'qty',
        'uom',
        'unit_price',
        'discount',
        'amount',
        'cbp_price',
        'cbp_total',
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
        'unit_price' => 'double',
        'amount' => 'double',
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

    public function header()
    {
        return $this->hasOne(SalesOrder::class, 'id', 'sales_order_id');
    }

    public function product()
    {
        return $this->hasOne(Product::class, 'InventoryCD', 'inventory_id');
    }

    // public function productFree()
    // {
    //     return $this->hasOne(BundlingProduct::class, 'product_code', 'inventory_id')->whereRaw('');
    // }

    public function bundlingDiscount()
    {
        return $this->hasOne(PacketDiscount::class, 'packet_code', 'packet_code');
    }

    
}
