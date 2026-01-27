<x-layout>
    <x-slot:title>
        User Profile
    </x-slot:title>

    <div>        
        <x-user-profile :user="$userProfile" :chirps="$chirps" />
    </div>
        <div class="max-w-2xl mx-auto mt-8">
            @forelse ($chirps as $chirp)
                <h1>Your Chirps:</h1>
                <x-chirp :chirp="$chirp" />
            @empty
                <div class="hero py-12">
                    <div class="hero-content text-center">
                        <div>
                            <svg class="mx-auto h-12 w-12 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <!-- SVG content -->
                            </svg>
                            <h3 class="text-xl mt-4">No chirps yet</h3>
                            <p class="opacity-70 mt-2">You haven't posted any chirps yet.</p>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
</x-layout>