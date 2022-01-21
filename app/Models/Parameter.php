<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Parameter
 * @package App\Models
 * @version January 20, 2022, 7:51 am UTC
 *
 * @property string $name
 * @property string $parameter_string
 * @property string $parameter_date
 * @property time $parameter_hour
 * @property number $parameter_number
 */
class Parameter extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'parameters';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'parameter_string',
        'parameter_date',
        'parameter_hour',
        'parameter_number'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'parameter_string' => 'string',
        'parameter_date' => 'date',
        'parameter_number' => 'float'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required'
    ];

    
}
