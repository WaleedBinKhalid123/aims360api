<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipHero_Aims360 extends Model
{

    /**
     * fields have to be filled manually
     *
     * @var string[]
     */
    protected $fillable = [
        'graphql_product_id',
        'GQL_ID',
        'name',
        'sku',
        'aims360_product_id',
        'styleColorID',
        'style',
        'color'
    ];
    public function qraph_ql_product()
    {
        return $this->belongsTo('App\Models\QraphQlProduct');
    }

    public function aims360__product()
    {
        return $this->belongsTo('App\Models\Aims360_Product');
    }

}
