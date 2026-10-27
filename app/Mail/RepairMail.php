<?php

namespace App\Mail;

use Illuminate\Support\Facades\Log;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RepairMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $email_data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email_data)
    {
        $this->email_data = $email_data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        Log::info(json_encode($this->email_data));

        return $this->view('emails.repair_notify_admin')
            ->subject("New Asset Maintenance Request")
            ->from('admin@sisfs.com.au', 'New Asset Maintenance Request')
            ->with(['data' => $this->email_data]);
    }
}
