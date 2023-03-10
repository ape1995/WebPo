<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class MailSetting
 * @package App\Models
 * @version January 21, 2022, 2:07 pm WIB
 *
 * @property string $type
 * @property string $sub_type
 * @property string $email
 * @property string $password
 * @property boolean $status
 */
class MailSetting extends Model
{

    use HasFactory;

    public $table = 'mail_settings';



    public $fillable = [
        'name',
        'type',
        'sub_type',
        'email',
        'password',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'type' => 'string',
        'sub_type' => 'string',
        'email' => 'string',
        'password' => 'string',
        'status' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
