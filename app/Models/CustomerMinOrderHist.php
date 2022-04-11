<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class CustomerMinOrderHist
 * @package App\Models
 * @version March 10, 2022, 10:19 am WIB
 *
 * @property string $customer_code
 * @property integer $old_price
 * @property integer $new_price
 */
class CustomerMinOrderHist extends Model
{

    use HasFactory;

    public $table = 'customer_min_order_hists';
    



    public $fillable = [
        'customer_code',
        'old_price',
        'new_price'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'customer_code' => 'string',
        'old_price' => 'integer',
        'new_price' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
