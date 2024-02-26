<?php

namespace App\Mail;

use App\Models\Service;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserNotification extends Mailable
{
    use Queueable, SerializesModels;
    protected $user;
    protected $order;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order, $user)
    {
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
        $orderids = collect($this->order->services)->pluck('service_id');
        $services =   Service::whereIn('id', $orderids)->select('id', 'title', 'basic_price', 'slug', 'duration')->get();


        return $this->markdown(
            'emails.user-notification',
            ['order' => $this->order, 'services' => $services, 'user' => $this->user]
        )->subject('New Booking Notification');
    }
}