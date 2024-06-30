<x-content>
    <x-content.title :title="__('Courses')" :description="__('List of available courses.')" />

    <x-form.select block :items="$curricula
        ->map(
            fn($curriculum) => [
                'title' =>
                    '(' .
                    $curriculum->code .
                    ') ' .
                    $curriculum->name .
                    ($curriculum->is_active ? ' (' . __('Active') . ')' : ''),
                'value' => $curriculum->id,
            ],
        )
        ->toArray()" wire:model.live='activeCurriculum' />

    @foreach (range(1, 8) as $semester)
        <div class="space-y-3 border-b py-9 mb-9 last:border-b-0 border-primary-700 dark:border-gray-700 sm:space-y-4">
            <div class="p-6 text-center bg-white shadow dark:bg-slate-800 sm:p-8">
                <div class="text-xl font-bold uppercase text-primary-700 dark:text-primary-300">
                    {{ __(':semester Semester', ['semester' => $semester]) }}
                </div>
            </div>

            <x-table :columns="[
                '#',
                __('Code'),
                __(':name Name', ['name' => __('Course')]),
                __('CC'),
                __('Description'),
                __('Lectures'),
            ]">
                <x-slot name="body">
                    @forelse ($courses->where('semester',$semester) as $course)
                        <x-table.tr>
                            <x-table.td class="w-16" centered>
                                {{ $loop->iteration }}
                            </x-table.td>
                            <x-table.td centered>
                                {{ $course->code }}
                            </x-table.td>
                            <x-table.td>
                                {{ $course->name }}
                            </x-table.td>
                            <x-table.td centered>
                                {{ $course->credit }}
                            </x-table.td>
                            <x-table.td>
                                {{ $course->description }}
                            </x-table.td>
                            <x-table.td centered>
                                <x-tooltip :title="__('View :view', ['view' => __('Lectures')])">
                                    <x-button color="primary" icon="i-ph-eye" size="sm"
                                        x-on:click="$dispatch('toggle-show-lectures-modal')"
                                        wire:click="$dispatch('setShowLectures', { type: 'course', course: {{ $course->id }} })">
                                        {{ $course->lectures()->count() }}
                                        {{ $course->lectures()->count() <= 1 ? __('Lecture') : __('Lectures') }}
                                    </x-button>
                                </x-tooltip>
                            </x-table.td>
                        </x-table.tr>
                    @empty
                        <x-table.tr>
                            <x-table.td colspan="8">
                                <x-no-data />
                            </x-table.td>
                        </x-table.tr>
                    @endforelse
                </x-slot>
            </x-table>
        </div>
    @endforeach

    <div wire:ignore>
        <x-modal name="show-lectures-modal" size="full" :modalTitle="__('Show :show', ['show' => __('Lectures')])">
            <livewire:staff.lecture.show-data />
        </x-modal>
    </div>
</x-content>
