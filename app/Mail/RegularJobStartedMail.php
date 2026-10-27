<?php

namespace App\Mail;

use Illuminate\Support\Facades\Log;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use System\Employee\Models\Employee;
use App\Modules\JobManage\Models\Job;
use App\Modules\JobManage\Models\RegularJobTransaction;

class RegularJobStartedMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $job;
    protected $reg_trans;
    protected $employee;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Job $job,RegularJobTransaction $reg_trans,Employee $employee)
    {
        $this->job = $job;
        $this->reg_trans = $reg_trans;
        $this->employee = $employee;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // Log::info(json_encode($this->job));
        // Log::info(json_encode($this->reg_trans));

        return $this->from('admin@sisfs.com.au', 'SISFS - Job Started')
            ->subject($this->job->reference_no.' Job Started')
            ->view('emails.rjob_started_customer')
            ->with([
                'data' => $this->job,
                'summery' => $this->reg_trans,
                'employee' => $this->employee
            ]);
    }
}
