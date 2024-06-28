<x-content>
    <x-box-grid>
        <x-box :color="$colors[rand(0, count($colors) - 1)]" icon="i-ph-student" :to="route('staff.student')" :title="__('Active Students')" :number="$activeStudents"></x-box>
        <x-box :color="$colors[rand(0, count($colors) - 1)]" icon="i-ph-student" :to="route('staff.student', ['viewActive' => 'students_passed'])" :title="__('Students Passed')" :number="$studentsPassed"></x-box>
        <x-box :color="$colors[rand(0, count($colors) - 1)]" icon="i-ph-student" :to="route('staff.student', ['viewActive' => 'student_registration'])" :title="__('Students Not Registered Yet')" :number="$studentsNotRegistered"></x-box>
        <x-box :color="$colors[rand(0, count($colors) - 1)]" icon="i-ph-student" :to="route('staff.student')" :title="__(':total Total', ['total' => __('Student')])" :number="$allStudents"></x-box>
        <x-box :color="$colors[rand(0, count($colors) - 1)]" icon="i-ph-chalkboard-teacher-fill" :to="route('staff.lecturer')" :title="__(':total Total', ['total' => __('Lecturer')])"
            :number="$lecturers"></x-box>
        <x-box :color="$colors[rand(0, count($colors) - 1)]" icon="i-ph-lego-smiley" :to="route('staff.staff')" :title="__(':total Total', ['total' => __('Staff')])"
            :number="$staff"></x-box>
        <x-box :color="$colors[rand(0, count($colors) - 1)]" icon="i-ph-house" :to="route('staff.room')" :title="__(':total Total', ['total' => __('Room')])" :number="$rooms"></x-box>
        <x-box :color="$colors[rand(0, count($colors) - 1)]" icon="i-ph-bookmark" :to="route('staff.curriculum')" :title="__(':total Total', ['total' => __('Curriculum')])" :number="$curricula"></x-box>
        <x-box :color="$colors[rand(0, count($colors) - 1)]" icon="i-ph-notebook" :to="route('staff.course')" :title="__(':total Total', ['total' => __('Courses')])" :number="$courses"></x-box>
        <x-box :color="$colors[rand(0, count($colors) - 1)]" icon="i-ph-clock-user" :to="route('staff.lecture')" :title="__(':total Total', ['total' => __('Lectures')])"
            :number="$lectures"></x-box>
        <x-box :color="$colors[rand(0, count($colors) - 1)]" icon="i-ph-money-wavy" :to="route('staff.payment')" :title="__(':total Total', ['total' => __('Payments')])"
            :number="$lectures"></x-box>
    </x-box-grid>
</x-content>
