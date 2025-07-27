<?php

namespace App\Models;

use App\Models\Players\Player;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'external_country_id',
        'name',
        'code',
        'image_path',
    ];

    /** Relationships */
    
    /**
     * Get the players associated with a country.
     */
    public function players(): HasMany
    {
        return $this->hasMany(Player::class, 'nationality_id', 'external_country_id');
    }
}
