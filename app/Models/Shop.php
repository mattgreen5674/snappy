<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shop extends Model
{
    /** @use HasFactory<\Database\Factories\ShopFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'latitude',
        'longitude',
        'status',
        'type',
        'max_delivery_distance',
    ];
}
