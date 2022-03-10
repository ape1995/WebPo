<?php

namespace App\Repositories;

use App\Models\CustomerMinOrderHist;
use App\Repositories\BaseRepository;

/**
 * Class CustomerMinOrderHistRepository
 * @package App\Repositories
 * @version March 10, 2022, 10:19 am WIB
*/

class CustomerMinOrderHistRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'customer_code',
        'old_price',
        'new_price'
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
        return CustomerMinOrderHist::class;
    }
}
