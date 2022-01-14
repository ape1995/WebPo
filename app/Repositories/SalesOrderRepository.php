<?php

namespace App\Repositories;

use App\Models\SalesOrder;
use App\Repositories\BaseRepository;

/**
 * Class SalesOrderRepository
 * @package App\Repositories
 * @version January 10, 2022, 3:20 am UTC
*/

class SalesOrderRepository extends BaseRepository
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
        'updated_by',
        'canceled_by',
        'canceled_at',
        'submitted_by',
        'submitted_at',
        'rejected_by',
        'rejected_at',
        'rejected_reason',
        'processed_by',
        'processed_at'
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
        return SalesOrder::class;
    }
}
