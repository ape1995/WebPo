<?php

namespace App\Repositories;

use App\Models\CategoryMinOrder;
use App\Repositories\BaseRepository;

/**
 * Class CategoryMinOrderRepository
 * @package App\Repositories
 * @version March 29, 2022, 3:30 pm WIB
*/

class CategoryMinOrderRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'category',
        'minimum_order',
        'start_date',
        'end_date'
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
        return CategoryMinOrder::class;
    }
}
