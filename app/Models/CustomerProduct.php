<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class CustomerProduct
 * @package App\Models
 * @version March 10, 2022, 10:16 am WIB
 *
 * @property string $customer_code
 * @property string $inventory_code
 * @property string $customer_class
 */
class CustomerProduct extends Model
{

    use HasFactory;

    public $table = 'customer_products';
    

    public $fillable = [
        'customer_code',
        'inventory_code',
        'customer_class'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'customer_code' => 'string',
        'inventory_code' => 'string',
        'customer_class' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    public function customer()
    {
        return $this->hasOne(Customer::class, 'AcctCD', 'customer_code');
    }

    public function product()
    {
        return $this->hasOne(Product::class, 'InventoryCD', 'inventory_code');
    }
    
}
