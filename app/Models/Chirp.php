<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Chirp extends Model
{
    protected $fillable = [
    	'message',
    ];

    public function user(): BelongsTo
    {
    	return $this->belongsTo(User::class);
    }

    /**
     * The users who have hearted this chirp.
    */
    public function heartedBy()
    {
        return $this->belongsToMany(\App\Models\User::class, 'chirp_user')
                    ->withTimestamps();
    }

    /**
     * Helper: is this chirp hearted by the passed user (or current user if null)?
    */
    public function isHeartedBy(?\App\Models\User $user = null): bool
    {
        $user = $user ?? auth()->user();

        if (! $user) {
            return false;
        }

        // If the relation was eager loaded, use the loaded collection to avoid extra queries:
        if ($this->relationLoaded('heartedBy')) {
            return $this->heartedBy->contains('id', $user->id);
        }

        return $this->heartedBy()->where('user_id', $user->id)->exists();
    }
}
