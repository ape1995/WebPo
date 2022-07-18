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
    use SoftDeletes;

    use HasFactory;

    public $table = 'bundling_products';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'start_date',
        'end_date',
        'product_code',
        'qty'
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

    
}
