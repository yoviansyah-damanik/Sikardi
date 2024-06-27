<div id="steps"
    class="relative flex flex-col p-3 bg-white bg-left bg-no-repeat bg-cover shadow-sm cursor-default dark:bg-slate-700 sm:bg-contain rounded-xl"
    style="background-image: url('{{ Vite::image('wave-1.svg') }}')">
    <div id="step-rules" class="flex flex-col items-center justify-center gap-3 sm:flex-row">
        <div @class([
            'relative flex flex-row items-center justify-center w-full h-16 gap-3 p-4 overflow-hidden bg-gradient-to-br sm:w-80 sm:gap-1 sm:items-end sm:h-28 sm:flex-col rounded-xl',
            'text-gray-700 from-gray-50 to-gray-100' => !$steps['submission'],
            'text-green-700 from-green-50 to-green-100' =>
                $steps['submission'] == 'completed',
            'text-red-700 from-red-50 to-red-100' => $steps['submission'] == 'failed',
            'text-yellow-700 from-yellow-50 to-yellow-100 step-animation' =>
                $steps['submission'] == 'on_going',
        ])>
            <span class="i-ph-signature size-10 opacity-70"></span>
            <div class="font-semibold leading-none text-end">
                {{ __('Submission') }}
            </div>
        </div>
        <div
            class="h-12 w-12 rotate-90 sm:rotate-0 [clip-path:_polygon(50%_0,_100%_50%,_50%_100%,_0_100%,_50%_53%,_0%_0%)] bg-blue-100">
        </div>
        <div class="flex flex-row items-stretch w-full max-w-5xl gap-3 justify-stretch sm:flex-col sm:h-auto">
            <div @class([
                'relative flex flex-col items-center justify-center w-7/12 gap-1 p-4 overflow-hidden bg-gradient-to-br sm:flex-row sm:gap-3 sm:h-16 sm:w-full rounded-xl',
                'text-gray-700 from-gray-50 to-gray-100' => !$steps['guidance']['recap'],
                'text-green-700 from-green-50 to-green-100' =>
                    $steps['guidance']['recap'] == 'completed',
                'text-red-700 from-red-50 to-red-100' =>
                    $steps['guidance']['recap'] == 'failed',
                'text-yellow-700 from-yellow-50 to-yellow-100 step-animation' =>
                    $steps['guidance']['recap'] == 'on_going',
            ])>
                <span class="i-ph-book-open-text size-10 opacity-70"></span>
                <div class="font-semibold leading-none text-end">
                    {{ __('Guidance') }}
                </div>
            </div>
            <div class="flex flex-col flex-1 w-5/12 gap-3 sm:w-full sm:flex-row">
                <div @class([
                    'relative grid w-full h-8 overflow-hidden font-semibold rounded-lg bg-gradient-to-br  place-items-center',
                    'text-gray-700 from-gray-50 to-gray-100' => !$steps['guidance']['bab_1'],
                    'text-green-700 from-green-50 to-green-100' =>
                        $steps['guidance']['bab_1'] == 'completed',
                    'text-red-700 from-red-50 to-red-100' =>
                        $steps['guidance']['bab_1'] == 'failed',
                    'text-yellow-700 from-yellow-50 to-yellow-100 step-animation' =>
                        $steps['guidance']['bab_1'] == 'on_going',
                ])>
                    BAB 1
                    <div
                        class="absolute right-0 pr-3 text-6xl font-bold -translate-y-1/2 opacity-30 text-inherit rotate-12 top-1/2">
                        1
                    </div>
                </div>
                <div @class([
                    'relative grid w-full h-8 overflow-hidden font-semibold rounded-lg bg-gradient-to-br  place-items-center',
                    'text-gray-700 from-gray-50 to-gray-100' => !$steps['guidance']['bab_2'],
                    'text-green-700 from-green-50 to-green-100' =>
                        $steps['guidance']['bab_2'] == 'completed',
                    'text-red-700 from-red-50 to-red-100' =>
                        $steps['guidance']['bab_2'] == 'failed',
                    'text-yellow-700 from-yellow-50 to-yellow-100 step-animation' =>
                        $steps['guidance']['bab_2'] == 'on_going',
                ])>
                    BAB 2
                    <div
                        class="absolute right-0 pr-3 text-6xl font-bold -translate-y-1/2 opacity-30 text-inherit rotate-12 top-1/2">
                        2
                    </div>
                </div>
                <div @class([
                    'relative grid w-full h-8 overflow-hidden font-semibold rounded-lg bg-gradient-to-br  place-items-center',
                    'text-gray-700 from-gray-50 to-gray-100' => !$steps['guidance']['bab_3'],
                    'text-green-700 from-green-50 to-green-100' =>
                        $steps['guidance']['bab_3'] == 'completed',
                    'text-red-700 from-red-50 to-red-100' =>
                        $steps['guidance']['bab_3'] == 'failed',
                    'text-yellow-700 from-yellow-50 to-yellow-100 step-animation' =>
                        $steps['guidance']['bab_3'] == 'on_going',
                ])>
                    BAB 3
                    <div
                        class="absolute right-0 pr-3 text-6xl font-bold -translate-y-1/2 opacity-30 text-inherit rotate-12 top-1/2">
                        3
                    </div>
                </div>
                <div @class([
                    'relative grid w-full h-8 overflow-hidden font-semibold rounded-lg bg-gradient-to-br  place-items-center',
                    'text-gray-700 from-gray-50 to-gray-100' => !$steps['guidance']['bab_4'],
                    'text-green-700 from-green-50 to-green-100' =>
                        $steps['guidance']['bab_4'] == 'completed',
                    'text-red-700 from-red-50 to-red-100' =>
                        $steps['guidance']['bab_4'] == 'failed',
                    'text-yellow-700 from-yellow-50 to-yellow-100 step-animation' =>
                        $steps['guidance']['bab_4'] == 'on_going',
                ])>
                    BAB 4
                    <div
                        class="absolute right-0 pr-3 text-6xl font-bold -translate-y-1/2 opacity-30 text-inherit rotate-12 top-1/2">
                        4
                    </div>
                </div>
                <div @class([
                    'relative grid w-full h-8 overflow-hidden font-semibold rounded-lg bg-gradient-to-br  place-items-center',
                    'text-gray-700 from-gray-50 to-gray-100' => !$steps['guidance']['bab_5'],
                    'text-green-700 from-green-50 to-green-100' =>
                        $steps['guidance']['bab_5'] == 'completed',
                    'text-red-700 from-red-50 to-red-100' =>
                        $steps['guidance']['bab_5'] == 'failed',
                    'text-yellow-700 from-yellow-50 to-yellow-100 step-animation' =>
                        $steps['guidance']['bab_5'] == 'on_going',
                ])>
                    BAB 5
                    <div
                        class="absolute right-0 pr-3 text-6xl font-bold -translate-y-1/2 opacity-30 text-inherit rotate-12 top-1/2">
                        5
                    </div>
                </div>
                <div @class([
                    'relative grid w-full h-8 font-semibold rounded-lg bg-gradient-to-br  place-items-center',
                    'text-gray-700 from-gray-50 to-gray-100' => !$steps['guidance']['all'],
                    'text-green-700 from-green-50 to-green-100' =>
                        $steps['guidance']['all'] == 'completed',
                    'text-red-700 from-red-50 to-red-100' =>
                        $steps['guidance']['all'] == 'failed',
                    'text-yellow-700 from-yellow-50 to-yellow-100 step-animation' =>
                        $steps['guidance']['all'] == 'on_going',
                ])>
                    {{ __('All') }}
                    <div
                        class="absolute right-0 pr-3 text-6xl font-bold -translate-y-1/2 opacity-30 text-inherit rotate-12 top-1/2">
                        6
                    </div>
                </div>
            </div>
        </div>
        <div
            class="h-12 w-12 rotate-90 sm:rotate-0 [clip-path:_polygon(50%_0,_100%_50%,_50%_100%,_0_100%,_50%_53%,_0%_0%)] bg-blue-100">
        </div>
        <div @class([
            'relative flex flex-row items-center justify-center w-full h-16 gap-3 p-4 overflow-hidden bg-gradient-to-br sm:w-80 sm:gap-1 sm:items-end sm:h-28 sm:flex-col rounded-xl',
            'text-gray-700 from-gray-50 to-gray-100' => !$steps['finish'],
            'text-green-700 from-green-50 to-green-100' =>
                $steps['finish'] == 'completed',
            'text-red-700 from-red-50 to-red-100' => $steps['finish'] == 'failed',
            'text-yellow-700 from-yellow-50 to-yellow-100 step-animation' =>
                $steps['finish'] == 'on_going',
        ])>
            <span class="i-ph-checks size-10 opacity-70"></span>
            <div class="font-semibold leading-none text-end">
                {{ __('Finish') }}
            </div>
        </div>
    </div>
    <div id="step-explanation"
        class="inline-flex flex-col items-center justify-center w-full gap-1 px-3 py-2 mx-auto mt-3 text-sm bg-white rounded-md sm:px-6 sm:w-auto sm:bg-white/30 backdrop-blur dark:bg-slate-700 sm:dark:bg-transparent sm:flex-row sm:gap-3">
        <div class="dark:text-gray-100">
            {{ __('Explanation') }}:
        </div>
        <div id="step" class="flex items-center justify-center gap-5">
            <div id="step-completed" class="flex items-center gap-1">
                <div class="w-3 h-3 border border-green-700 bg-gradient-to-br from-green-50 to-green-100"></div>
                <div class="text-green-700">{{ __('Completed') }}</div>
            </div>
            <div id="step-failed" class="flex items-center gap-1">
                <div class="w-3 h-3 bg-red-100 border border-red-700"></div>
                <div class="text-red-700">{{ __('Failed') }}</div>
            </div>
            <div id="step-on-going" class="flex items-center gap-1">
                <div class="w-3 h-3 bg-yellow-100 border border-yellow-700"></div>
                <div class="text-yellow-700">{{ __('On Going') }}</div>
            </div>
        </div>
    </div>
</div>
