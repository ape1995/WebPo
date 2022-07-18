<?php

namespace App\Repositories;

use App\Models\BundlingGimmick;
use App\Repositories\BaseRepository;

/**
 * Class BundlingGimmickRepository
 * @package App\Repositories
 * @version July 18, 2022, 10:37 am WIB
*/

class BundlingGimmickRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'start_date',
        'end_date',
        'package_type',
        'nominal',
        'free_qty',
        'free_descr'
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
        return BundlingGimmick::class;
    }
}
