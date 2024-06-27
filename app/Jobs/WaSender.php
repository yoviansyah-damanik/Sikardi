<?php

namespace App\Jobs;

use App\Helpers\WaHelper;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class WaSender implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public String $msg;
    public String | array $dest;

    /**
     * Create a new job instance.
     */
    public function __construct(String $msg, String | array $dest)
    {
        $this->msg = $msg;
        $this->dest = $dest;
    }

    /**
     * Calculate the number of seconds to wait before retrying the job.
     *
     * @return array<int, int>
     */
    public function backoff(): array
    {
        return [1, 5, 10];
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        WaHelper::sendMessage($this->msg, $this->dest);
    }
}
