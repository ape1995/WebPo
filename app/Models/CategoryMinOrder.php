<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class CategoryMinOrder
 * @package App\Models
 * @version March 29, 2022, 3:30 pm WIB
 *
 * @property string $category
 * @property integer $minimum_order
 * @property string $start_date
 * @property string $end_date
 */
class CategoryMinOrder extends Model
{
    
    use HasFactory;

    public $table = 'category_min_orders';


    public $fillable = [
        'category',
        'minimum_order',
        'start_date',
        'end_date'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'category' => 'string',
        'minimum_order' => 'integer',
        'start_date' => 'date',
        'end_date' => 'date'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'category' => 'required'
    ];

    
}
