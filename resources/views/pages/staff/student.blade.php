<x-content>
    <x-content.title :title="__('Students')" :description="__('List of registered student data.')" />

    <div class="hidden gap-3 sm:flex">
        <x-form.input class="flex-1" type="search" :placeholder="__('Search by :1 or :2', ['1' => 'NPM', '2' => __(':name Name', ['name' => __('Student')])])" block wire:model.live.debounce.750ms='search' />
        <x-form.select :items="$activationTypes" wire:model.live='activationType' :loading="$viewActive != 'registered_students'" />
        <x-button color="primary" icon="i-ph-plus"
            x-on:click="$dispatch('toggle-create-student-modal')">{{ __('Add :add', ['add' => __('Student')]) }}</x-button>
        <x-button wire:click='download' color="primary" icon="i-ph-download">{{ __('Download') }}</x-button>
    </div>
    <div class="flex flex-col gap-3 sm:hidden">
        <x-form.input block type="search" :placeholder="__('Search by :1 or :2', ['1' => 'NPM', '2' => __(':name Name', ['name' => __('Student')])])" block wire:model.live.debounce.750ms='search' />
        <x-form.select block :items="$activationTypes" wire:model.live='activationType' :loading="$viewActive != 'registered_students'" />
        <x-button block color="primary" icon="i-ph-plus"
            x-on:click="$dispatch('toggle-create-student-modal')">{{ __('Add :add', ['add' => __('Student')]) }}</x-button>
        <x-button block wire:click='download' color="primary" icon="i-ph-download">{{ __('Download') }}</x-button>
    </div>

    <div>
        <div class="flex overflow-hidden shadow rounded-xl">
            @foreach ($viewList as $idx => $view)
                <label for="view-{{ $idx + 1 }}"
                    class="relative flex-1 gap-1 overflow-hidden border-r cursor-pointer last:border-r-0">
                    <input name="view" wire:loading.attr='disabled' wire:model.live='viewActive'
                        class="hidden peer/view" id="view-{{ $idx + 1 }}" type="radio"
                        value="{{ $view }}" />
                    <div
                        class="w-full h-full px-3 py-2 font-medium text-center text-gray-700 bg-primary-50 peer-checked/view:text-gray-100 peer-checked/view:bg-primary-700 peer-checked/view:opacity-100 ">
                        {{ __(Str::headline($view)) }}
                    </div>
                </label>
            @endforeach
        </div>
        @error('type')
            <div class="mt-1 text-red-700">
                {{ $message }}
            </div>
        @enderror
    </div>

    @if ($viewActive == 'registered_students')
        <x-table :columns="[
            '#',
            'NPM',
            __('Fullname'),
            __('Semester'),
            __('Stamp'),
            __('Gender'),
            __('Supervisor'),
            __(':status Status', ['status' => __('CSS')]),
            __(':status Status', ['status' => __('User')]),
            '',
        ]">
            <x-slot name="body">
                @forelse ($students as $student)
                    <x-table.tr>
                        <x-table.td class="w-16" centered>
                            {{ $students->perPage() * ($students->currentPage() - 1) + $loop->iteration }}
                        </x-table.td>
                        <x-table.td centered>
                            {{ $student['data']['npm'] }}
                        </x-table.td>
                        <x-table.td>
                            {{ $student['data']['name'] }}
                        </x-table.td>
                        <x-table.td centered>
                            {{ $student['data']['semester'] }}
                        </x-table.td>
                        <x-table.td centered>
                            {{ $student['data']['stamp'] }}
                        </x-table.td>
                        <x-table.td centered>
                            {{ $student['data']['gender'] }}
                        </x-table.td>
                        <x-table.td centered>
                            @if ($student['supervisor'])
                                <x-supervisor-box :supervisor="$student['supervisor']" />
                            @else
                                <div class="text-center">
                                    -
                                </div>
                            @endif
                        </x-table.td>
                        <x-table.td centered>
                            <x-badge :type="$student['status'] == 'approved'
                                ? 'success'
                                : ($student['status'] == 'waiting'
                                    ? 'warning'
                                    : 'error')">
                                {{ __(Str::headline($student['status'])) }}
                            </x-badge>
                        </x-table.td>
                        <x-table.td centered>
                            <x-badge :type="$student['user']['is_suspended'] ? 'error' : 'success'">
                                {{ $student['user']['is_suspended'] ? __('Suspended') : __('Active') }}
                            </x-badge>
                        </x-table.td>
                        <x-table.td centered class="w-36">
                            <x-tooltip :title="__('Assign Supervisor')">
                                <x-button color="yellow" size="sm" icon="i-ph-pen"
                                    x-on:click="$dispatch('toggle-assign-supervisor-modal')"
                                    wire:click="$dispatch('setAssignSupervisor', { student: '{{ $student['data']['npm'] }}' } )">
                                </x-button>
                            </x-tooltip>
                            <x-tooltip :title="__('View')">
                                <x-button color="cyan" icon="i-ph-eye" size="sm"
                                    x-on:click="$dispatch('toggle-show-student-modal')"
                                    wire:click="$dispatch('setStudent', { student: '{{ $student['data']['npm'] }}' } )">
                                </x-button>
                            </x-tooltip>
                            <x-tooltip :title="__('View :view', ['view' => __('CSS')])">
                                <x-button color="yellow" icon="i-ph-list-heart" size="sm"
                                    x-on:click="$dispatch('toggle-show-student-css-modal')"
                                    wire:click="$dispatch('setStudent', { student: '{{ $student['data']['npm'] }}' } )">
                                </x-button>
                            </x-tooltip>
                            <x-tooltip :title="__('Activation Menu')">
                                <x-button size="sm" icon="i-ph-user-check" color="green"
                                    x-on:click="$dispatch('toggle-user-activation-modal')"
                                    wire:click="$dispatch('setUserActivation',{ user: {{ $student['user']['id'] }} })" />
                            </x-tooltip>
                            <x-tooltip :title="__('Set Pass Status')">
                                <x-button size="sm" icon="i-ph-user-list" color="red"
                                    x-on:click="$dispatch('toggle-set-pass-status-modal')"
                                    wire:click="$dispatch('setPassStatus',{ student: {{ $student['data']['npm'] }}, passType: 'passed' })" />
                            </x-tooltip>
                        </x-table.td>
                    </x-table.tr>
                @empty
                    <x-table.tr>
                        <x-table.td colspan="10">
                            <x-no-data />
                        </x-table.td>
                    </x-table.tr>
                @endforelse
            </x-slot>

            <x-slot name="paginate">
                {{ $students->links(data: ['scrollTo' => 'table']) }}
            </x-slot>
        </x-table>
    @elseif($viewActive == 'student_registration')
        <x-table :columns="['#', 'NPM', __('Fullname'), __('Email'), __('Phone Number'), __('Token'), __('Expired Date'), '']">
            <x-slot name="body">
                @forelse ($students as $student)
                    <x-table.tr>
                        <x-table.td class="w-20" centered>
                            {{ $students->perPage() * ($students->currentPage() - 1) + $loop->iteration }}
                        </x-table.td>
                        <x-table.td centered>
                            {{ $student->student_id }}
                        </x-table.td>
                        <x-table.td>
                            {{ $student->name }}
                        </x-table.td>
                        <x-table.td>
                            {{ $student->email }}
                        </x-table.td>
                        <x-table.td centered>
                            {{ $student->phone_number }}
                        </x-table.td>
                        <x-table.td centered>
                            <x-form.input type="password" :value="$student->token" :readonly="true">
                            </x-form.input>
                        </x-table.td>
                        <x-table.td centered>
                            {{ $student->expired_at ? \Carbon\Carbon::parse($student->expired_at)->translatedFormat('d F Y H:i:s') : '-' }}
                        </x-table.td>
                        <x-table.td centered>
                            <x-tooltip :title="__('Delete')">
                                <x-button size="sm" icon="i-ph-trash" color="red"
                                    x-on:click="$dispatch('toggle-delete-registration-modal')"
                                    wire:click="$dispatch('setDeleteRegistration',{ register: {{ $student->id }} })" />
                            </x-tooltip>
                        </x-table.td>
                    </x-table.tr>
                @empty
                    <x-table.tr>
                        <x-table.td colspan="10">
                            <x-no-data />
                        </x-table.td>
                    </x-table.tr>
                @endforelse
            </x-slot>

            <x-slot name="paginate">
                {{ $students->links(data: ['scrollTo' => false]) }}
            </x-slot>
        </x-table>
    @elseif($viewActive == 'students_passed')
        <x-table :columns="[
            '#',
            'NPM',
            __('Fullname'),
            __('Passed Semester'),
            __('Passed Year'),
            __('Grade Point Average (GPA)'),
            __('Supervisor'),
            __(':status Status', ['status' => __('User')]),
            '',
        ]">
            <x-slot name="body">
                @forelse ($students as $student)
                    <x-table.tr>
                        <x-table.td class="w-16" centered>
                            {{ $students->perPage() * ($students->currentPage() - 1) + $loop->iteration }}
                        </x-table.td>
                        <x-table.td centered>
                            {{ $student['data']['npm'] }}
                        </x-table.td>
                        <x-table.td>
                            {{ $student['data']['name'] }}
                        </x-table.td>
                        <x-table.td centered>
                            {{ $student['is_passed']['data']['semester'] }}
                        </x-table.td>
                        <x-table.td centered>
                            {{ $student['is_passed']['data']['year'] }}
                        </x-table.td>
                        <x-table.td centered>
                            {{ $student['is_passed']['data']['gpa'] }}
                        </x-table.td>
                        <x-table.td>
                            @if ($student['supervisor'])
                                <x-supervisor-box :supervisor="$student['supervisor']" />
                            @else
                                <div class="text-center">
                                    -
                                </div>
                            @endif
                        </x-table.td>

                        <x-table.td centered>
                            <x-badge :type="$student['user']['is_suspended'] ? 'error' : 'success'">
                                {{ $student['user']['is_suspended'] ? __('Suspended') : __('Active') }}
                            </x-badge>
                        </x-table.td>
                        <x-table.td centered class="w-36">
                            <x-tooltip :title="__('Assign Supervisor')">
                                <x-button color="yellow" size="sm" icon="i-ph-pen"
                                    x-on:click="$dispatch('toggle-assign-supervisor-modal')"
                                    wire:click="$dispatch('setAssignSupervisor', { student: '{{ $student['data']['npm'] }}' } )">
                                </x-button>
                            </x-tooltip>
                            <x-tooltip :title="__('View')">
                                <x-button color="cyan" icon="i-ph-eye" size="sm"
                                    x-on:click="$dispatch('toggle-show-student-modal')"
                                    wire:click="$dispatch('setStudent', { student: '{{ $student['data']['npm'] }}' } )">
                                </x-button>
                            </x-tooltip>
                            <x-tooltip :title="__('View :view', ['view' => __('CSS')])">
                                <x-button color="yellow" icon="i-ph-list-heart" size="sm"
                                    x-on:click="$dispatch('toggle-show-student-css-modal')"
                                    wire:click="$dispatch('setStudent', { student: '{{ $student['data']['npm'] }}' } )">
                                </x-button>
                            </x-tooltip>
                            <x-tooltip :title="__('Activation Menu')">
                                <x-button size="sm" icon="i-ph-user-check" color="green"
                                    x-on:click="$dispatch('toggle-user-activation-modal')"
                                    wire:click="$dispatch('setUserActivation',{ user: {{ $student['user']['id'] }} })" />
                            </x-tooltip>
                            <x-tooltip :title="__('Set Pass Status')">
                                <x-button size="sm" icon="i-ph-user-list" color="red"
                                    x-on:click="$dispatch('toggle-set-pass-status-modal')"
                                    wire:click="$dispatch('setPassStatus',{ student: {{ $student['data']['npm'] }}, passType: 'passed' })" />
                            </x-tooltip>
                        </x-table.td>
                    </x-table.tr>
                @empty
                    <x-table.tr>
                        <x-table.td colspan="10">
                            <x-no-data />
                        </x-table.td>
                    </x-table.tr>
                @endforelse
            </x-slot>

            <x-slot name="paginate">
                {{ $students->links(data: ['scrollTo' => 'table']) }}
            </x-slot>
        </x-table>
    @endif

    <div wire:ignore>
        <x-modal name="user-activation-modal" size="xl" :modalTitle="__('User Activation')">
            <livewire:users.user-activation />
        </x-modal>
        <x-modal name="show-student-modal" size="3xl" :modalTitle="__(':data Data', ['data' => __('Student')])">
            <livewire:student.show-data />
        </x-modal>
        <x-modal name="show-student-css-modal" size="full" :modalTitle="__('Show :show', ['show' => __('CSS')])">
            <livewire:student.show-data-css />
        </x-modal>
        <x-modal name="create-student-modal" size="3xl" :modalTitle="__('Add :add', ['add' => __('Student')])">
            <livewire:student.create />
        </x-modal>
        <x-modal name="delete-registration-modal" size="xl" :modalTitle="__('Delete Registration')">
            <livewire:student.delete-registration />
        </x-modal>
        <x-modal name="assign-supervisor-modal" size="3xl" :modalTitle="__('Assign Supervisor')">
            <livewire:student.assign-supervisor />
        </x-modal>
        <x-modal name="set-pass-status-modal" size="3xl" :modalTitle="__('Set Pass Status')">
            <livewire:student.set-pass-status />
        </x-modal>
    </div>
</x-content>
