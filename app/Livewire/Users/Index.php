<?php

namespace App\Livewire\Users;

use Livewire\Component;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\JoinClause;

class Index extends Component
{
    use WithPagination;

    protected $listeners = ['refreshUsers' => '$refresh', 'refreshUserActivation' => '$refresh', 'setSearch', 'setViewActive'];

    #[Url]
    public string $search = '';

    public array $activationTypes;
    public array $userTypes;

    #[Url]
    public string $userType;

    #[Url]
    public string $activationType;

    public function mount()
    {
        $this->userTypes = [
            [
                'title' => __('All'),
                'value' => 'all'
            ],
            [
                'title' => __('Student'),
                'value' => \App\Models\Student::class
            ],
            [
                'title' => __('Lecturer'),
                'value' => \App\Models\Lecturer::class
            ],
            [
                'title' => __('Staff'),
                'value' => \App\Models\Staff::class
            ]
        ];
        $this->userType = $this->userTypes[0]['value'];

        $this->activationTypes = [
            [
                'title' => __('All'),
                'value' => 'all'
            ],
            [
                'title' => __('Active'),
                'value' => 'active'
            ],
            [
                'title' => __('Suspended'),
                'value' => 'suspended'
            ],
        ];
        $this->activationType = $this->activationTypes[0]['value'];
    }

    public function render()
    {
        $users = DB::table('users', 'a')
            ->select(
                'a.id as user_id',
                'a.is_suspended',
                'a.email',
                'a.last_login_at',
                'b.userable_type as type',
                DB::raw("CASE WHEN c.phone_number IS NULL THEN CASE WHEN d.phone_number IS NULL THEN e.phone_number ELSE d.phone_number END ELSE c.phone_number END AS phone_number"),
                DB::raw("CASE WHEN c.id IS NULL THEN CASE WHEN d.id IS NULL THEN e.id ELSE d.id END ELSE c.id END AS id"),
                DB::raw("CASE WHEN c.name IS NULL THEN CASE WHEN d.name IS NULL THEN e.name ELSE d.name END ELSE c.name END AS name")
            )
            ->join('user_types as b', 'a.id', '=', 'b.user_id')
            ->leftJoin('lecturers as c', function (JoinClause $join) {
                $join->on('b.userable_id', '=', 'c.id');
            })
            ->leftJoin('students as d', function (JoinClause $join) {
                $join->on('b.userable_id', '=', 'd.id');
            })
            ->leftJoin('staff as e', function (JoinClause $join) {
                $join->on('b.userable_id', '=', 'e.id');
            });

        if ($this->activationType != 'all') {
            $users = $users->where('is_suspended', $this->activationType  == 'suspended' ? true : false);
        }

        if ($this->userType != 'all') {
            $users = $users->where('userable_type', $this->userType);
        }

        $users = $users
            ->whereAny(['c.id', 'd.id', 'e.id', 'c.name', 'd.name', 'e.name'], 'like', "$this->search%")
            ->orderBy('type')
            ->paginate(15);

        return view('pages.users.index', compact('users'))
            ->title(__('User Management'));
    }

    public function updated($attribute)
    {
        $this->resetPage();
    }

    public function setSearch($search)
    {
        $this->search = $search;
    }
}
