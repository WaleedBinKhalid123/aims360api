<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Aims360_Product extends Model
{
    use HasFactory,Notifiable;

    /**
     * fields have to be filled manually
     *
     * @var string[]
     */
    protected $fillable = [
        'styleColorID',
        'style',
        'color',
        'description',
        'status'
    ];
}
