<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class PacketDiscount
 * @package App\Models
 * @version June 15, 2022, 4:30 pm WIB
 *
 * @property string $packet_code
 * @property string $packet_name
 * @property string $start_date
 * @property string $end_date
 * @property string $rbp_class
 * @property string $released_date
 * @property string $description
 * @property string $status
 * @property integer $total
 * @property integer $discount
 * @property integer $grand_total
 */
class PacketDiscount extends Model
{
    use HasFactory;

    public $table = 'packet_discounts';



    public $fillable = [
        'packet_code',
        'packet_name',
        'start_date',
        'end_date',
        'rbp_class',
        'released_date',
        'description',
        'status',
        'total',
        'discount',
        'grand_total'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'packet_code' => 'string',
        'packet_name' => 'string',
        'start_date' => 'date',
        'end_date' => 'date',
        'rbp_class' => 'string',
        'released_date' => 'date',
        'description' => 'string',
        'status' => 'string',
        'total' => 'integer',
        'discount' => 'integer',
        'grand_total' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    public function detail()
    {
        return $this->hasMany(PacketDiscountDetail::class, 'packet_discount_id', 'id');
    }

    
}
