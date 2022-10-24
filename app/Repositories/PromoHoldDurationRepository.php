<?php

namespace App\Repositories;

use App\Models\PromoHoldDuration;
use App\Repositories\BaseRepository;

/**
 * Class PromoHoldDurationRepository
 * @package App\Repositories
 * @version October 21, 2022, 5:09 pm WIB
*/

class PromoHoldDurationRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'packet_type',
        'duration_in_day',
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
        return PromoHoldDuration::class;
    }
}
