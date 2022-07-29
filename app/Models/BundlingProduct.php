<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class BundlingProduct
 * @package App\Models
 * @version July 18, 2022, 11:35 am WIB
 *
 * @property string $start_date
 * @property string $end_date
 * @property string $product_code
 * @property integer $qty
 */
class BundlingProduct extends Model
{

    use HasFactory;

    public $table = 'bundling_products';
    



    public $fillable = [
        'start_date',
        'end_date',
        'product_code',
        'product_name',
        'qty',
        'created_by',
        'released_at',
        'released_by',
        'updated_by',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
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

    public function detail()
    {
        return $this->hasMany(BundlingProductFree::class, 'bundling_product_id', 'id');
    }
}
