<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OnClientPayment extends Mailable
{
    use Queueable, SerializesModels;
    public $metadata;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($metadata)
    {
        $this->metadata = $metadata;
        $this->subject('Rental Invoice');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.onClientPayment');
    }
}
