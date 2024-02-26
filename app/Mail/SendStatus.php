<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendStatus extends Mailable
{
    use Queueable, SerializesModels;
    protected $status;
    protected $user;
    protected $order;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($status, $user, $order)
    {
        $this->status = $status;
        $this->user = $user;
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->markdown('emails.send-status', [
            'status' => $this->status,
            'user' => $this->user,
            'order' => $this->order
        ])->subject('Booking Status');
    }
}