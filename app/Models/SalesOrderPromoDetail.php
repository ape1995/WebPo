<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class SalesOrderPromoDetail
 * @package App\Models
 * @version June 17, 2022, 2:10 pm WIB
 *
 * @property integer $sales_order_promo_id
 * @property integer $packet_code
 * @property integer $qty
 * @property number $unit_price
 * @property number $total
 */
class SalesOrderPromoDetail extends Model
{
   
    use HasFactory;

    public $table = 'sales_order_promo_details';


    public $fillable = [
        'sales_order_promo_id',
        'packet_code',
        'qty',
        'unit_price',
        'total'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'sales_order_promo_id' => 'integer',
        'packet_code' => 'string',
        'qty' => 'integer',
        'unit_price' => 'double',
        'total' => 'double'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    public function packet()
    {
        return $this->hasOne(PacketDiscount::class, 'packet_code', 'packet_code');
    }

    
}
