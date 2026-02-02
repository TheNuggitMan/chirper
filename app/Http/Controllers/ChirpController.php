<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Chirp;
use App\Models\User;

class ChirpController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $chirps = Chirp::with(['user', 'heartedBy'])
        ->latest()
        ->take(50)
        ->get();

        return view('home', ['chirps' => $chirps]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ], [
            'message.required' => 'Please write something to chirp!',
            'messgae.max' => 'Chirps must be 255 characters or less.',
        ]);

        auth()->user()->chirps()->create($validated);

        return redirect('/')->with('success', 'Your Chirp has been posted!');

    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $user = auth()->user();

        // eager load the user's chirps and heartedChirps
        $user->load(['chirps' => function ($q) { $q->latest(); }]);

        // Get all chirps this user has hearted
        $hearted = $user->heartedChirps()->with('user')->latest()->get();

        $filter = $request->query('filter', 'all');

        if ($filter === 'yours') {
            // only those hearted chirps that belong to the user
            $hearted = $hearted->filter(fn($c) => $c->user_id === $user->id)->values();
        }

        return view('auth.user', [
            'userProfile' => $user,
            'chirps' => $user->chirps,
            'heartedChirps' => $hearted,
            'heartFilter' => $filter,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chirp $chirp)
    {

        $this->authorize('update', $chirp);
        
        return view('chirps.edit', compact('chirp'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chirp $chirp)
    {

        $this->authorize('update', $chirp);

        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ], [
            'message.required' => 'Please write something to chirp!',
            'messgae.max' => 'Chirps must be 255 characters or less.',
        ]);

        $chirp->update($validated);

        return redirect('/')->with('success', 'Your Chirp has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chirp $chirp)
    {

        $this->authorize('update', $chirp);

        $chirp->delete();

        return redirect('/')->with('success', 'Your Chirp has been deleted!');
    }
}
