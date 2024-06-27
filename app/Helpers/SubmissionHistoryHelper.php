<?php

namespace App\Helpers;

use App\Enums\SubmissionHistoryStatus;
use App\Models\Submission;
use App\Models\SubmissionHistory;

class SubmissionHistoryHelper
{
    public static function get(Submission $submission)
    {
        return SubmissionHistory::where('submission_id', $submission->id)
            ->get();
    }

    public static function set(Submission $submission, string $status, string $message): bool
    {
        if (!in_array($status, SubmissionHistoryStatus::names()))
            return false;

        SubmissionHistory::create([
            'submission_id' => $submission->id,
            'message' => $message,
            'status' => $status
        ]);

        return true;
    }
}
