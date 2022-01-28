<?php

namespace App\Repositories;

use App\Models\Add;
use App\Repositories\BaseRepository;

/**
 * Class AddRepository
 * @package App\Repositories
 * @version January 28, 2022, 8:41 am WIB
*/

class AddRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'image',
        'description'
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
        return Add::class;
    }
}
