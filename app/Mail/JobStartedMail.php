<?php

namespace App\Mail;

use Illuminate\Support\Facades\Log;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class JobStartedMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $job;
    protected $summery;
    protected $employee;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($job,$summery,$employee)
    {
        $this->job = $job;
        $this->summery = $summery;
        $this->employee = $employee;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('admin@sisfs.com.au', 'SISFS - Job Started')
            ->subject($this->job->reference_no.' Job Started')
            ->view('emails.job_started_customer')
            ->with([
                'data' => $this->job,
                'summery' => $this->summery,
                'employee' => $this->employee
            ]);
    }
}
