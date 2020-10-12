<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipHero_Aims360 extends Model
{
    use HasFactory;

    /**
     * fields have to be filled manually
     *
     * @var string[]
     */
    protected $fillable = [
        'graphql_product_id',
        'aims360_product_id'
    ];
}
