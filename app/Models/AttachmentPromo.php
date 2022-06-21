<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Attachment
 * @package App\Models
 * @version February 2, 2022, 8:15 am WIB
 *
 * @property int $sales_order_id
 * @property string $type
 * @property string $image
 */
class AttachmentPromo extends Model
{

    use HasFactory;

    public $table = 'attachment_promos';
    


    public $fillable = [
        'sales_order_promo_id',
        'type',
        'image'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'type' => 'string',
        'image' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
