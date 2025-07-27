<?php

namespace App\Models\Players;

use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Player extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'external_player_id',
        'first_name',
        'last_name',
        'date_of_birth',
        'gender',
        'position_id',
        'detailed_position_id',
        'nationality_id',
        'image_path',
    ];

    /** Relationships */
    
    /**
     * Get the general position associated with the player.
     */
    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class, 'position_id', 'external_position_id');
    }

    /**
     * Get the parent position associated with the player.
     */
    public function parentPosition(): BelongsTo
    {
        return $this->belongsTo(Position::class, 'parent_position_id', 'external_position_id');
    }

    /**
     * Get the country associated with a player's nationality.
     */
    public function nationality(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'nationality_id', 'external_country_id');
    }
}
