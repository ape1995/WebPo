<?php

namespace App\Repositories;

use App\Models\CustomerFirstOrder;
use App\Repositories\BaseRepository;

/**
 * Class CustomerFirstOrderRepository
 * @package App\Repositories
 * @version October 21, 2022, 4:52 pm WIB
*/

class CustomerFirstOrderRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'customer_code',
        'first_order_number',
        'first_order_date',
        'created_by',
        'updated_by'
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
        return CustomerFirstOrder::class;
    }
}
