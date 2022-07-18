<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class BundlingProductFree
 * @package App\Models
 * @version July 18, 2022, 11:36 am WIB
 *
 * @property integer $bundling_product_id
 * @property string $product_code
 * @property integer $qty
 */
class BundlingProductFree extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'bundling_product_frees';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'bundling_product_id',
        'product_code',
        'qty',
        'user_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'bundling_product_id' => 'integer',
        'product_code' => 'string',
        'qty' => 'integer'
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
        return $this->hasOne(Product::class, 'InventoryCD', 'product_code');
    }
}
