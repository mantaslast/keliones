<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReservationSuccessfull extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $link;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order, $link)
    {
        $this->order = $order;
        $this->link = $link;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.successfull');
    }
}
