<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Add
 * @package App\Models
 * @version January 28, 2022, 8:41 am WIB
 *
 * @property string $name
 * @property string $image
 * @property string $description
 */
class Add extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'adds';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'image',
        'description'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'image' => 'string',
        'description' => 'string'
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
