<?php

namespace App\Repositories;

use App\Models\Attachment;
use App\Repositories\BaseRepository;

/**
 * Class AttachmentRepository
 * @package App\Repositories
 * @version February 2, 2022, 8:15 am WIB
*/

class AttachmentPromoRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'sales_order_id',
        'type',
        'image'
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
        return Attachment::class;
    }
}
