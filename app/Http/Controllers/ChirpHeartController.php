<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use Illuminate\Http\Request;

class ChirpHeartController extends Controller
{
    /**
     * Attach a heart from the authenticated user to a chirp.
    */
    public function store(Chirp $chirp)
    {
        $user = auth()->user();

        if (! $user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        // Attach unless already attached
        $chirp->heartedBy()->syncWithoutDetaching([$user->id]);

        return response()->json([
            'status' => 'hearted',
            'heart_count' => $chirp->heartedBy()->count(),
        ]);
    }

    /**
     * Remove a heart from the authenticated user on the chirp.
    */
    public function destroy(Chirp $chirp)
    {
        $user = auth()->user();

        if (! $user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $chirp->heartedBy()->detach($user->id);

        return response()->json([
            'status' => 'unhearted',
            'heart_count' => $chirp->heartedBy()->count(),
        ]);
    }
}