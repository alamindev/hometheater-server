<?php

namespace App\Mail;

use App\Models\Service;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminNotificationNewOrder extends Mailable
{
    use Queueable, SerializesModels;
    protected $user;
    protected $carts;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order, $dateTime, $user)
    {
        $this->user = $user;
        $this->carts = $carts; 
        $this->dateTime = $dateTime; 
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {  
        return $this->markdown('emails.admin-new-booking-status', [
            'user' => $this->user,
            'carts' => $this->carts, 
        ])->subject('Order Status'); 
    }
}