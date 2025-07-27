<?php

namespace App\Models\Players;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Position extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'player_positions';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'external_position_id',
        'name',
    ];

    /** Relationships */
    
    /**
     * Get the players associated with the parent position.
     */
    public function parentPlayers(): HasMany
    {
        return $this->hasMany(Player::class, 'parent_position_id', 'external_position_id');
    }

    /**
     * Get the players associated with a position.
     */
    public function players(): HasMany
    {
        return $this->hasMany(Player::class, 'position_id', 'external_position_id');
    }
}
