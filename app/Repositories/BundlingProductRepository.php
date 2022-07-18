<?php

namespace App\Repositories;

use App\Models\BundlingProduct;
use App\Repositories\BaseRepository;

/**
 * Class BundlingProductRepository
 * @package App\Repositories
 * @version July 18, 2022, 11:35 am WIB
*/

class BundlingProductRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'start_date',
        'end_date',
        'product_code',
        'qty'
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
        return BundlingProduct::class;
    }
}
