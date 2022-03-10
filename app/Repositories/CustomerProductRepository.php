<?php

namespace App\Repositories;

use App\Models\CustomerProduct;
use App\Repositories\BaseRepository;

/**
 * Class CustomerProductRepository
 * @package App\Repositories
 * @version March 10, 2022, 10:16 am WIB
*/

class CustomerProductRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'customer_code',
        'inventory_code',
        'customer_class'
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
        return CustomerProduct::class;
    }
}
