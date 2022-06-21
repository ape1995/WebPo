<?php

namespace App\Repositories;

use App\Models\CartPromo;
use App\Repositories\BaseRepository;

/**
 * Class CartPromoRepository
 * @package App\Repositories
 * @version June 17, 2022, 3:14 pm WIB
*/

class CartPromoRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
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
        return CartPromo::class;
    }
}
