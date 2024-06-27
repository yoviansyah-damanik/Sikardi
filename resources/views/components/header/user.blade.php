<a class="flex items-center gap-3 p-1 rounded-full cursor-pointer bg-primary-700" wire:navigate
    href="{{ route('account') }}">
    <img class="rounded-full size-10" src="{{ Vite::image('user.png') }}" alt="User Icon" />
    <div class="flex flex-col py-1 font-semibold w-44 sm:w-52">
        <div class="pr-6 text-sm truncate sm:text-base text-primary-100">
            {{ Auth::user()->data->name }}
        </div>
        <div class="text-xs font-light text-primary-50">
            {{ Auth::user()->role == 'lecturer' ? 'NIDN. ' : (Auth::user()->role == 'student' ? 'NPM. ' : __(':type Id', ['type' => __('Staff')])) }}
            {{ Auth::user()->data->id }}
        </div>
    </div>
</a>
