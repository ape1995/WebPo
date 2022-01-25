<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class ParameterVAT
 * @package App\Models
 * @version January 25, 2022, 2:10 pm WIB
 *
 * @property string $name
 * @property integer $value
 * @property string $start_date
 * @property string $end_date
 */
class ParameterVAT extends Model
{
    use HasFactory;

    public $table = 'parameter_v_a_ts';



    public $fillable = [
        'name',
        'value',
        'start_date',
        'end_date'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'value' => 'integer',
        'start_date' => 'date',
        'end_date' => 'date'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
