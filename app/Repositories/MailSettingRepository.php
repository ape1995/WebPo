<?php

namespace App\Repositories;

use App\Models\MailSetting;
use App\Repositories\BaseRepository;

/**
 * Class MailSettingRepository
 * @package App\Repositories
 * @version January 21, 2022, 2:07 pm WIB
*/

class MailSettingRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'type',
        'sub_type',
        'email',
        'password',
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
        return MailSetting::class;
    }
}
