<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class BundlingGimmick
 * @package App\Models
 * @version July 18, 2022, 10:37 am WIB
 *
 * @property string $start_date
 * @property string $end_date
 * @property string $package_type
 * @property integer $nominal
 * @property integer $free_qty
 * @property string $free_descr
 */
class BundlingGimmick extends Model
{

    use HasFactory;

    public $table = 'bundling_gimmicks';


    public $fillable = [
        'start_date',
        'end_date',
        'package_type',
        'nominal',
        'free_qty',
        'free_descr',
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
        'package_type' => 'string',
        'nominal' => 'string',
        'free_qty' => 'integer',
        'free_descr' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
