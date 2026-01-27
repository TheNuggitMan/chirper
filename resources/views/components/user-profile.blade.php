@props(['user'])

<div class="flex space-x-3">
  @if($chirp->user)
      <div class="avatar">
          <div class="size-10 rounded-full">
              <img src="https://avatars.laravel.cloud/{{ urlencode($chirp->user->email) }}"
                   alt="{{ $chirp->user->name }}'s avatar"
                   class="rounded-full" />
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
  @endif

  <div class="min-w-0 flex-1">
      <div class="flex justify-between w-full">
          <div class="flex items-center gap-1">
              <span class="text-sm font-semibold">{{ $chirp->user ? $chirp->user->name : 'Anonymous' }}</span>
              <span class="text-base-content/60">·</span>
              <span class="text-sm text-base-content/60">{{ $chirp->created_at->diffForHumans() }}</span>
              @if ($chirp->updated_at->gt($chirp->created_at->addSeconds(5)))
                  <span class="text-base-content/60">.</span>
                  <span class="text-sm text-base-content/60 italic">edited</span>
              @endif
          </div>

          @can('update', $chirp)
              <div class="flex gap-1">
                  <a href="/chirps/{{ $chirp->id }}/edit" class="btn btn-ghost btn-xs">
                      Edit
                  </a>
                  <form action="/chirps/{{ $chirp->id }}" method="POST">
                      @csrf
                      @method('DELETE')
                      <button type="submit" onclick="return confirm('Are you sure you want to delete this chirp?')"
                          class="btn btn-ghost btn-xs text-error">
                          Delete
                      </button>
                  </form>
              </div>
          @endcan
      </div>
      <p class="mt-1">{{ $chirp->message }}</p>
  </div>
</div>