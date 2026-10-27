<?php

namespace App\Mail;

use Illuminate\Support\Facades\Log;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class JobFinishedMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $job;
    protected $summery;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($job,$summery)
    {
        $this->job = $job;
        $this->summery = $summery;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        Log::info(json_encode($this->job));
        Log::info(json_encode($this->summery));

        return $this->view('emails.job_finished_admin')
            ->subject("SISFS Job Finished - ".$this->job->reference_no)
            ->from('admin@sisfs.com.au', $this->job->reference_no.' Job Finished')
            ->with(['data' => $this->job,'summery' => $this->summery]);
    }
}
