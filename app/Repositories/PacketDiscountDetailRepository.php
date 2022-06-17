<?php

namespace App\Repositories;

use App\Models\PacketDiscountDetail;
use App\Repositories\BaseRepository;

/**
 * Class PacketDiscountDetailRepository
 * @package App\Repositories
 * @version June 15, 2022, 4:41 pm WIB
*/

class PacketDiscountDetailRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'packet_discount_id',
        'inventory_code',
        'inventory_name',
        'qty',
        'unit_price',
        'total_amount',
        'discount_percentage',
        'discount_amount',
        'amount'
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
        return PacketDiscountDetail::class;
    }
}
