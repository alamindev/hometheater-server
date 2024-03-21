<?php

namespace App\Mail;

use App\Models\Service;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Order;

class AdminNotificationNewOrder extends Mailable
{
    use Queueable, SerializesModels;
    protected $order_ids; 
    protected $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order_ids, $user)
    {
        $this->user = $user;
        $this->order_ids = $order_ids;  
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {  
        $service =  Order::with('orderdate','services')
        ->whereIn('id', $this->order_ids) 
        ->where('user_id',  $this->user['id'])->where('type', 0)->first();

        $product =  Order::with('orderdate', 'services')
        ->whereIn('id', $this->order_ids) 
        ->where('user_id', $this->user['id'])->where('type', 1)->first();

        
        return $this->markdown('emails.admin-new-booking-status', [
            'user' => $this->user, 
            'product' => $product, 
            'service' => $service, 
        ])->subject('Order Status'); 
    }
}