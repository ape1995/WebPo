<?php

namespace App\Repositories;

use App\Models\CustomerMinOrder;
use App\Repositories\BaseRepository;

/**
 * Class CustomerMinOrderRepository
 * @package App\Repositories
 * @version March 10, 2022, 10:18 am WIB
*/

class CustomerMinOrderRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'customer_code',
        'minimum_order',
        'start_date',
        'end_date',
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
        return CustomerMinOrder::class;
    }
}
