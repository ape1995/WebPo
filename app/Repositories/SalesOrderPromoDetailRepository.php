<?php

namespace App\Repositories;

use App\Models\SalesOrderPromoDetail;
use App\Repositories\BaseRepository;

/**
 * Class SalesOrderPromoDetailRepository
 * @package App\Repositories
 * @version June 17, 2022, 2:10 pm WIB
*/

class SalesOrderPromoDetailRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'sales_order_promo_id',
        'packet_code',
        'qty',
        'unit_price',
        'total'
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
        return SalesOrderPromoDetail::class;
    }
}
