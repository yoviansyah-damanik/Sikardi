<x-modal.body>
    @if (!$isLoading)
        @if (!empty($student))
            <div class="space-y-3 text-gray-700 sm:space-y-4 dark:text-gray-100" key="student_view">
                <div class="flex items-start">
                    <div class="w-44 sm:w-64 lg:w-80">
                        {{ __('NPM') }}
                    </div>
                    <div class="flex-1 font-semibold">
                        @if (auth()->user()->role == 'staff')
                            <a href="{{ route('staff.student', ['search' => $student['data']['npm'] ?? '-']) }}"
                                wire:navigate>{{ $student['data']['npm'] ?? '-' }}</a>
                        @elseif(auth()->user()->role == 'lecturer')
                            <a href="{{ route('lecturer.student', ['search' => $student['data']['npm'] ?? '-']) }}"
                                wire:navigate>{{ $student['data']['npm'] ?? '-' }}</a>
                        @else
                            {{ $student['data']['npm'] ?? '-' }}
                        @endif
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="w-44 sm:w-64 lg:w-80">
                        {{ __('Name') }}
                    </div>
                    <div class="flex-1">
                        {{ $student['data']['name'] ?? '-' }}
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="w-44 sm:w-64 lg:w-80">
                        {{ __('Address') }}
                    </div>
                    <div class="flex-1">
                        {{ $student['data']['address'] ?? '-' }}
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="w-44 sm:w-64 lg:w-80">
                        {{ __('Place of Birth') }}
                    </div>
                    <div class="flex-1">
                        {{ $student['data']['place_of_birth'] ?? '-' }}
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="w-44 sm:w-64 lg:w-80">
                        {{ __('Date of Birth') }}
                    </div>
                    <div class="flex-1">
                        {{ !empty($student['data']['date_of_birth']) ? \Carbon\Carbon::parse($student['data']['date_of_birth'])->translatedFormat('d F Y') : '-' }}
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="w-44 sm:w-64 lg:w-80">
                        {{ __('Stamp') }}
                    </div>
                    <div class="flex-1">
                        {{ $student['data']['stamp'] ?? '-' }}
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="w-44 sm:w-64 lg:w-80">
                        {{ __('Semester') }}
                    </div>
                    <div class="flex-1">
                        {{ $student['data']['semester'] ?? '-' }}
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="w-44 sm:w-64 lg:w-80">
                        {{ __('Phone Number') }}
                    </div>
                    <div class="flex-1">
                        {{ $student['data']['phone_number'] ?? '-' }}
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="w-44 sm:w-64 lg:w-80">
                        {{ __('Email') }}
                    </div>
                    <div class="flex-1 break-all">
                        {{ $student['user']['email'] ?? '-' }}
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="w-44 sm:w-64 lg:w-80">
                        {{ __('Supervisor') }}
                    </div>
                    <div class="flex-1">
                        <x-supervisor-box :supervisor="$student['supervisor']" />
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="w-44 sm:w-64 lg:w-80">
                        {{ __(':status Status', ['status' => __('CSS')]) }}
                    </div>
                    <div class="flex-1">
                        <x-badge :type="$student['status'] == 'approved'
                            ? 'success'
                            : ($student['status'] == 'waiting'
                                ? 'warning'
                                : 'error')">
                            {{ __(Str::headline($student['status'])) }}
                        </x-badge>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="w-44 sm:w-64 lg:w-80">
                        {{ __('User Status') }}
                    </div>
                    <div class="flex-1">
                        <x-badge :type="$student['user']['is_suspended'] ? 'error' : 'success'">
                            {{ $student['user']['is_suspended'] ? __('Suspended') : __('Active') }}
                        </x-badge>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="w-44 sm:w-64 lg:w-80">
                        {{ __(':status Status', ['status' => __('Passed')]) }}
                    </div>
                    <div class="flex-1">
                        <x-badge :type="$student['is_passed']['status'] ? 'success' : 'warning'">
                            {{ $student['is_passed']['message'] }}
                        </x-badge>
                    </div>
                </div>
                @if ($student['is_passed']['status'])
                    <div class="flex items-start">
                        <div class="w-44 sm:w-64 lg:w-80">
                            {{ __('Grade') }}
                        </div>
                        <div class="flex-1">
                            {{ $student['is_passed']['data']['grade'] }}
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="w-44 sm:w-64 lg:w-80">
                            {{ __('Grade in Numbers') }}
                        </div>
                        <div class="flex-1">
                            {{ $student['is_passed']['data']['grade_number'] }}
                        </div>
                    </div>
                @endif
            </div>
        @else
            <x-no-data />
        @endif
    @else
        <x-loading />
    @endif
</x-modal.body>
