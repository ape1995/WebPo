<?php

namespace App\Repositories;

use App\Models\DsPercentage;
use App\Repositories\BaseRepository;

/**
 * Class DsPercentageRepository
 * @package App\Repositories
 * @version June 7, 2022, 8:19 am WIB
*/

class DsPercentageRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'start_date',
        'end_date',
        'percentage'
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
        return DsPercentage::class;
    }
}
