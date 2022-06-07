<?php

namespace App\Repositories;

use App\Models\DsRule;
use App\Repositories\BaseRepository;

/**
 * Class DsRuleRepository
 * @package App\Repositories
 * @version June 7, 2022, 8:17 am WIB
*/

class DsRuleRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'status'
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
        return DsRule::class;
    }
}
