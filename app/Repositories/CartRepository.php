<?php

namespace App\Repositories;

use App\Models\Cart;
use App\Repositories\BaseRepository;

/**
 * Class CartRepository
 * @package App\Repositories
 * @version January 11, 2022, 1:35 am UTC
*/

class CartRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'inventory_id',
        'inventory_name',
        'qty',
        'uom',
        'unit_price',
        'amount',
        'created_by',
        'updated_by',
        'customer_id'
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
        return Cart::class;
    }
}
