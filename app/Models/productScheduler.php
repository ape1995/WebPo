<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class productScheduler
 * @package App\Models
 * @version July 29, 2022, 1:19 pm WIB
 *
 * @property string $date
 * @property string $inventory_code
 * @property string $customer_class
 * @property string $action_type
 */
class productScheduler extends Model
{

    use HasFactory;

    public $table = 'product_schedulers';


    public $fillable = [
        'date',
        'inventory_code',
        'customer_class',
        'action_type'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'date' => 'date',
        'inventory_code' => 'string',
        'customer_class' => 'string',
        'action_type' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    public function product()
    {
        return $this->hasOne(Product::class, 'InventoryCD', 'inventory_code');
    }

    
}
