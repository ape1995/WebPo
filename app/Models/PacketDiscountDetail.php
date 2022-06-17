<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class PacketDiscountDetail
 * @package App\Models
 * @version June 15, 2022, 4:41 pm WIB
 *
 * @property integer $packet_discount_id
 * @property string $inventory_code
 * @property string $inventory_name
 * @property integer $qty
 * @property integer $unit_price
 * @property integer $total_amount
 * @property number $discount_percentage
 * @property number $discount_amount
 * @property number $amount
 */
class PacketDiscountDetail extends Model
{
    use HasFactory;

    public $table = 'packet_discount_details';
    


    public $fillable = [
        'packet_discount_id',
        'inventory_code',
        'inventory_name',
        'qty',
        'unit_price',
        'total_amount',
        'discount_percentage',
        'discount_amount',
        'amount',
        'user_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'packet_discount_id' => 'integer',
        'inventory_code' => 'string',
        'inventory_name' => 'string',
        'qty' => 'integer',
        'unit_price' => 'integer',
        'total_amount' => 'integer',
        'discount_percentage' => 'decimal:4',
        'discount_amount' => 'decimal:4',
        'amount' => 'decimal:4',
        'user_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
