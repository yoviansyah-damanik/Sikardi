<div id="notification" class="relative overflow-hidden rounded-xl">
    <div id="notification-header" class="h-16 bg-white bg-cover border-b dark:bg-slate-700"
        style="background-image: url('{{ Vite::image('wave-2.svg') }}')">
        <div class="flex items-center h-full mx-3">
            <div class="text-base font-semibold text-white">
                {{ __('Notifications') }}
            </div>
        </div>
    </div>
    <div id="notification-body" class="overflow-y-auto h-[28rem] bg-white dark:bg-slate-700">
        @forelse ($notifications as $notification)
            <div
                class="relative px-4 py-3 transition duration-150 bg-white border-b dark:bg-slate-700 hover:bg-primary-50 dark:hover:bg-slate-500 last:border-b-0">
                @if ($notification['from'])
                    <div class="mb-1 dark:text-primary-100">
                        <div class="font-semibold">
                            {{ $notification['from']['name'] }}
                        </div>
                        <div class="text-sm text-gray-700">
                            {{ $notification['from_model'] }}
                        </div>
                    </div>
                @else
                    <div class="mb-1 font-semibold dark:text-primary-100">
                        {{ __('System') }}
                    </div>
                @endif
                <div class="flex items-start gap-3">
                    <div class="flex-none">
                        <span @class([
                            'size-4 mt-1',
                            'i-solar-check-circle-line-duotone text-green-700' =>
                                $notification['type'] == 'success',
                            'i-solar-close-circle-line-duotone text-red-700' =>
                                $notification['type'] == 'error',
                            'i-solar-danger-circle-line-duotone text-yellow-700' =>
                                $notification['type'] == 'warning',
                        ])></span>
                    </div>
                    <div class="flex-1 text-sm text-gray-700 dark:text-primary-50">
                        {{ $notification['message'] }}
                        <div class="flex items-center justify-between gap-3">
                            <div class="flex items-center gap-1 mt-1 text-xs font-italic">
                                <span class="i-solar-clock-circle-line-duotone size-3"></span>
                                {{ \Carbon\Carbon::parse($notification['created_at'])->diffForHumans() }}
                            </div>
                            @if ($notification['href'])
                                <a href="{{ $notification['href'] }}" wire:navigate
                                    class="flex items-center gap-1 mt-1 text-xs font-italic">
                                    {{ __('Show') }}
                                    <span class="i-solar-arrow-right-line-duotone size-3"></span>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <x-no-data />
        @endforelse
    </div>
</div>
