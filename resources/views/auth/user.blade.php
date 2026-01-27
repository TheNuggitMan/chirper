<x-layout>
    <x-slot:title>
        User Profile
    </x-slot:title>

    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold mt-8">{{ $userProfile->name }}'s Profile</h1>

        <div class="card bg-base-100 shadow mt-4">
            <div class="card-body">
                <p class="text-sm text-base-content/60">Email: {{ $userProfile->email }}</p>
                <p class="text-sm text-base-content/60">Chirps: {{ $chirps->count() }}</p>
            </div>
        </div>

        <div class="space-y-4 mt-8">
            @forelse ($chirps as $chirp)
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
    </div>
</x-layout>