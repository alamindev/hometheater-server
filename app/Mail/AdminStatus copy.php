<?php

namespace App\Mail;

use App\Models\Service;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminStatus extends Mailable
{
    use Queueable, SerializesModels;
    protected $user;
    protected $order;
    protected $edit;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order, $user, $edit)
    {
        $this->user = $user;
        $this->order = $order;
        $this->edit = $edit;
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
        if ($this->edit == true) {
            return $this->markdown('emails.edit-admin-status', [
                'user' => $this->user,
                'order' => $this->order,
                'services' => $services,
            ])->subject('User update booking');
        } else {
            return $this->markdown('emails.admin-status', [
                'user' => $this->user,
                'order' => $this->order,
                'services' => $services,
            ])->subject('New Booking Notification');
        }
    }
}