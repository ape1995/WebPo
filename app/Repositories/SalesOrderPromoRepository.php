<?php

namespace App\Repositories;

use App\Models\SalesOrderPromo;
use App\Repositories\BaseRepository;

/**
 * Class SalesOrderPromoRepository
 * @package App\Repositories
 * @version June 17, 2022, 10:31 am WIB
*/

class SalesOrderPromoRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'order_nbr',
        'customer_id',
        'order_date',
        'delivery_date',
        'order_qty',
        'order_amount',
        'tax',
        'order_total',
        'description',
        'status',
        'created_by',
        'updapted_by',
        'canceled_by',
        'canceled_at',
        'submitted_by',
        'submitted_at',
        'rejected_by',
        'rejected_at',
        'rejected_reason',
        'processed_by',
        'processed_at',
        'order_type'
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
        return SalesOrderPromo::class;
    }
}
