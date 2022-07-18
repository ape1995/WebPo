<?php

namespace App\Repositories;

use App\Models\BundlingProductFree;
use App\Repositories\BaseRepository;

/**
 * Class BundlingProductFreeRepository
 * @package App\Repositories
 * @version July 18, 2022, 11:36 am WIB
*/

class BundlingProductFreeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'bundling_product_id',
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
        return BundlingProductFree::class;
    }
}
