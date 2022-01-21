<?php

namespace App\Repositories;

use App\Models\Parameter;
use App\Repositories\BaseRepository;

/**
 * Class ParameterRepository
 * @package App\Repositories
 * @version January 20, 2022, 7:51 am UTC
*/

class ParameterRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'parameter_string',
        'parameter_date',
        'parameter_hour',
        'parameter_number'
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
        return Parameter::class;
    }
}
