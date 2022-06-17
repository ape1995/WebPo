<?php

namespace App\Repositories;

use App\Models\PacketDiscount;
use App\Repositories\BaseRepository;

/**
 * Class PacketDiscountRepository
 * @package App\Repositories
 * @version June 15, 2022, 4:30 pm WIB
*/

class PacketDiscountRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'packet_code',
        'packet_name',
        'start_date',
        'end_date',
        'rbp_class',
        'released_date',
        'description',
        'status',
        'total',
        'discount',
        'grand_total'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return PacketDiscount::class;
    }
}
