<?php

namespace App\Repositories;

use App\Models\productScheduler;
use App\Repositories\BaseRepository;

/**
 * Class productSchedulerRepository
 * @package App\Repositories
 * @version July 29, 2022, 1:19 pm WIB
*/

class productSchedulerRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'date',
        'inventory_code',
        'customer_class',
        'action_type'
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
        return productScheduler::class;
    }
}
