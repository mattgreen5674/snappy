<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostCode extends Model
{
    /** @use HasFactory<\Database\Factories\PostCodeFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'post_code',
        'latitude',
        'longitude',
    ];
}
