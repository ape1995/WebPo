<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class PromoHoldDuration
 * @package App\Models
 * @version October 21, 2022, 5:09 pm WIB
 *
 * @property string $packet_type
 * @property integer $duration_in_day
 * @property integer $created_by
 * @property integer $updated_by
 */
class PromoHoldDuration extends Model
{
    use HasFactory;

    public $table = 'promo_hold_durations';

    public $fillable = [
        'packet_type',
        'duration_in_day',
        'start_date',
        'end_date',
        'created_by',
        'updated_by'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'packet_type' => 'string',
        'duration_in_day' => 'integer',
        'created_by' => 'integer',
        'updated_by' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'packet_type' => 'required',
        'duration_in_day' => 'required'
    ];

    public function createdBy()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function updatedBy()
    {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }

    
}
