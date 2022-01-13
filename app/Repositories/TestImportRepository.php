<?php

namespace App\Repositories;

use App\Models\TestImport;
use App\Repositories\BaseRepository;

/**
 * Class TestImportRepository
 * @package App\Repositories
 * @version January 10, 2022, 1:50 am UTC
*/

class TestImportRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'email'
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
        return TestImport::class;
    }
}
