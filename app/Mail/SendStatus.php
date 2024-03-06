<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Service;
use Carbon\Carbon;

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
        $collection = collect($this->order->services);
        $ids = $collection->pluck('service_id'); 
        $delivery_time =  Service::whereIn('id', $ids)->avg('delivery_time');
        $startDate =  Carbon::parse($this->order->created_at);

        $date = $startDate->copy()->addDays(round($delivery_time))->format('d M y - h:i:s A');

        return $this->markdown('emails.send-status', [
            'status' => $this->status,
            'user' => $this->user,
            'order' => $this->order,
            'date' => $date
        ])->subject('Booking Status');
    }
}