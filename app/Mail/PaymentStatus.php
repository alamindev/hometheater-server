<?php

namespace App\Mail;

use App\Models\Service;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentStatus extends Mailable
{
    use Queueable, SerializesModels;
    protected $user;
    protected $carts;
    protected $price;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($carts, $price, $user)
    {
        $this->user = $user;
        $this->carts = $carts;
        $this->price = $price;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $orderids = collect($this->carts)->pluck('id');
        $services =   Service::whereIn('id', $orderids)->select('id', 'title', 'basic_price', 'slug', 'duration')->get();

        return $this->markdown(
            'emails.paymentstatus',
            ['price' => $this->price, 'services' => $services, 'user' => $this->user]
        )->subject('Payment Notification');
    }
}