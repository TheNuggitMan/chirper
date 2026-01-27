@props(['user','chirps'])

<div>
  @if($user)
    <div class="max-w-lg mx-auto">
      <div class="flex gap-4 items-end">        
        <div class="avatar-icon w-10 flex-none">
            <div class="size-10 rounded-full">
                <img src="https://avatars.laravel.cloud/{{ urlencode($user->email) }}"
                     alt="{{ $user->name }}'s avatar"
                     class="rounded-full" />
            </div>
        </div>
        <h1 class="flex-1 text-3xl font-bold mt-8">{{ $user->name }}'s Profile</h1>
      </div>

      <div class="card bg-base-100 shadow mt-4">
          <div class="card-body">
              <p class="text-sm text-base-content/60">Email: {{ $user->email }}</p>
              <p class="text-sm text-base-content/60">Chirps: {{ $chirps->count() }}</p>
          </div>
      </div>
    @else
      <div class="avatar placeholder">
          <div class="size-10 rounded-full">
              <img src="https://avatars.laravel.cloud/da94be04-2755-4bdc-a793-7c29bae2193e?vibe=stealth"
              alt="Anonymous User"
              class="rounded-full" />
          </div>
      </div>
  </div>
  @endif
</div>