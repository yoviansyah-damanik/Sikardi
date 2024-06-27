<?php

namespace App\Helpers;

use App\Models\Guidance;
use App\Models\GuidanceSubmission;
use App\Models\Lecturer;
use App\Models\Student;
use App\Models\Notification;
use App\Models\Staff;
use App\Models\Submission;

class NotificationHelper
{
    /**
     * @param $from | array | from_id & from_model
     * @param $to | string or array | to_id & to_model OR staff
     **/
    public static function sendNotify(array $from, array | string $to, string $type, ?string $href, $payload)
    {
        $msg = 'this is message from system';

        if ($type == 'storeSubmission') {
            $msg = __('I have submitted the title of my final assignment. Please check and confirm.') . ' - ' . $payload->title ?? '';
        }

        if ($type == 'updateSubmission') {
            $msg = __('I have changed the title of my final assignment. Please check and confirm.') . ' - ' . $payload->title ?? '';
        }

        if ($type == 'storeGuidance') {
            $msg = __('I have applied for guidance. Please check and confirm.') . ' - ' . $payload->title ?? '';
        }

        if (is_string($to) && $to == 'staff') {
            foreach (Staff::all() as $staff) {
                Notification::create([
                    'from_id' => $from['id'],
                    'from_model' => $from['model'],
                    'to_id' => $staff->id,
                    'to_model' => Staff::class,
                    'message' => $msg,
                    'href' => $href,
                    'type' => 'success',
                ]);
            }
        } else {
            Notification::create([
                'from_id' => $from['id'],
                'from_model' => $from['model'],
                'to_id' => $to['id'],
                'to_model' => $to['model'],
                'message' => $msg,
                'href' => $href,
                'type' => 'success',
            ]);
        }
    }

    public static function storeSubmission(Submission $submission)
    {
        Notification::create([
            'to_id' => auth()->user()->data->id,
            'to_model' => Student::class,
            'message' => __(':attribute created successfully.', ['attribute' => __('Submission')]) . " - " . $submission->title,
            'href' => route('student.submission'),
            'type' => 'success',
        ]);

        static::sendNotify(
            from: ['id' => auth()->user()->data->id, 'model' => Student::class],
            to: 'staff',
            type: 'storeSubmission',
            href: route('staff.approval', ['search' => auth()->user()->data->id]),
            payload: $submission
        );
    }

    public static function updateSubmission(Submission $submission)
    {
        Notification::create([
            'to_id' => auth()->user()->data->id,
            'to_model' => Student::class,
            'message' => __(':attribute updated successfully.', ['attribute' => __('Submission')]) . " - " . $submission->title,
            'href' => route('student.submission'),
            'type' => 'success',
        ]);

        static::sendNotify(
            from: ['id' => auth()->user()->data->id, 'model' => Student::class],
            to: 'staff',
            type: 'updateSubmission',
            href: route('staff.approval', ['search' => auth()->user()->data->id]),
            payload: $submission
        );
    }

    public static function deleteSubmission(Submission $submission)
    {
        Notification::create([
            'to_id' => auth()->user()->data->id,
            'to_model' => Student::class,
            'message' => __(':attribute deleted successfully.', ['attribute' => __('Submission')]) . " - " . $submission->title,
            'href' => route('student.submission'),
            'type' => 'success',
        ]);
    }

    public static function approveSubmission(Submission $submission)
    {
        Notification::create([
            'from_id' => auth()->user()->data->id,
            'from_model' => Staff::class,
            'to_id' => $submission->student->id,
            'to_model' => Student::class,
            'message' => __('Your submission has been approved. You can continue to the next stage.') . ' - ' . $submission->title,
            'href' => route('student.submission', ['submissionId' => $submission->id]),
            'type' => 'success',
        ]);
    }

    public static function rejectSubmission(Submission $submission)
    {
        Notification::create([
            'from_id' => auth()->user()->data->id,
            'from_model' => Staff::class,
            'to_id' => $submission->student->id,
            'to_model' => Student::class,
            'message' => __('Your submission has been rejected.') . ' - ' . $submission->title,
            'href' => route('student.submission', ['submissionId' => $submission->id]),
            'type' => 'success',
        ]);
    }

    public static function revisionSubmission(Submission $submission)
    {
        Notification::create([
            'from_id' => auth()->user()->data->id,
            'from_model' => Staff::class,
            'to_id' => $submission->student->id,
            'to_model' => Student::class,
            'message' => __('Your submission has been requested to be revised. Immediately make revisions then resubmit your submission.') . ' - ' . $submission->title,
            'href' => route('student.submission', ['submissionId' => $submission->id]),
            'type' => 'success',
        ]);
    }

    public static function storeGuidance(Guidance $guidance, GuidanceSubmission $submission)
    {
        Notification::create([
            'to_id' => auth()->user()->data->id,
            'to_model' => Student::class,
            'message' => __(':attribute created successfully.', ['attribute' => __("Guidance's Submission")]) . " - " . $submission->title,
            'href' => route('student.guidance'),
            'type' => 'success',
        ]);

        foreach (auth()->user()->data->supervisors as $supervisor) {
            static::sendNotify(
                from: ['id' => auth()->user()->data->id, 'model' => Student::class],
                to: ['id' => $supervisor->id, 'model' => Lecturer::class],
                type: 'storeGuidance',
                href: route('lecturer.guidance.review', ['student' => auth()->user()->data->id, 'guidance' => $guidance->id]),
                payload: $submission
            );
        }
    }

    public static function updateReview(string $title, array | Student $student)
    {
        if (is_array($student)) {
            $student = Student::find($student['npm']);
        }

        Notification::create([
            'to_id' => $student->id,
            'to_model' => Student::class,
            'from_id' => auth()->user()->data->id,
            'from_model' => Lecturer::class,
            'message' => __(':attribute updated successfully.', ['attribute' => __("Guidance's Review")]) . " - " . $title,
            'href' => route('student.guidance'),
            'type' => 'success',
        ]);
    }
}
