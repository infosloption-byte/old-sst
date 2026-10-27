<?php

namespace App\Mail;

use Illuminate\Support\Facades\Log;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InspectionFinishedMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $inspection;
    protected $summery;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($inspection,$summery)
    {
        $this->inspection = $inspection;
        $this->summery = $summery;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // Log::info(json_encode($this->inspection));
        Log::info(json_encode($this->summery));

        return $this->view('emails.inspection_finished_admin')
            ->subject("SISFS Inspection Complete - ".$this->inspection->reference_no)
            ->from('admin@sisfs.com.au', $this->inspection->reference_no.' Inspection Finished')
            ->attach(storage_path($this->inspection->report_pdf), [
                'as' => 'report.pdf',
                'mime' => 'application/pdf',
            ])
            ->with(['data' => $this->inspection,'summery' => $this->summery]);
    }
}
