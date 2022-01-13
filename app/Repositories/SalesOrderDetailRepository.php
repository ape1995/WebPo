<?php

namespace App\Repositories;

use App\Models\SalesOrderDetail;
use App\Repositories\BaseRepository;

/**
 * Class SalesOrderDetailRepository
 * @package App\Repositories
 * @version January 10, 2022, 3:24 am UTC
*/

class SalesOrderDetailRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'sales_order_id',
        'inventory_id',
        'inventory_name',
        'qty',
        'uom',
        'unit_price',
        'amount',
        'created_by',
        'updated_by'
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
        return SalesOrderDetail::class;
    }
}
