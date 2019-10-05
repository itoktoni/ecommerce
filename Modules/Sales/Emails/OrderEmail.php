<?php

namespace Modules\Sales\Emails;

use Plugin\Helper;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Modules\Sales\Models\Order;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $master;
    public $customer;
    public $forwarder;
    public $detail;

    public function __construct($order)
    {
        $this->master = $order;
        $this->customer = $order->customer;
        $this->forwarder = $order->forwarder;
        $this->detail = $order->detail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view(Helper::setViewEmail('order_email', 'sales'));
    }
}
