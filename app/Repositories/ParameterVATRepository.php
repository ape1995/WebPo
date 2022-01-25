<?php

namespace App\Repositories;

use App\Models\ParameterVAT;
use App\Repositories\BaseRepository;

/**
 * Class ParameterVATRepository
 * @package App\Repositories
 * @version January 25, 2022, 2:10 pm WIB
*/

class ParameterVATRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'value',
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
        return ParameterVAT::class;
    }
}
