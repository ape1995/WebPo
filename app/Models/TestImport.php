<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class TestImport
 * @package App\Models
 * @version January 10, 2022, 1:50 am UTC
 *
 * @property string $name
 * @property string $email
 */
class TestImport extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'test_imports';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'email'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'email' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
