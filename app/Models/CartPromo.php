<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class CartPromo
 * @package App\Models
 * @version June 17, 2022, 3:14 pm WIB
 *
 * @property string $packet_code
 * @property integer $qty
 * @property number $unit_price
 * @property number $total
 */
class CartPromo extends Model
{

    use HasFactory;

    public $table = 'cart_promos';
    


    public $fillable = [
        'packet_code',
        'qty',
        'unit_price',
        'total',
        'customer_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'packet_code' => 'string',
        'qty' => 'integer',
        'unit_price' => 'double',
        'total' => 'double',
        'customer_id' => 'integer'
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
