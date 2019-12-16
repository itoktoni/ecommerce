<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Modules\Finance\Dao\Models\Payment;
use Modules\Finance\Dao\Repositories\PaymentRepository;
use Modules\Sales\Emails\CreateOrderEmail;
use Modules\Sales\Dao\Repositories\OrderRepository;
use Modules\Sales\Emails\TestingOrderEmail;

class SendEmail extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:system';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This Commands To Sending Email';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $order = new OrderRepository();
        $order_data = $order->dataRepository()->whereNull('sales_order_email_date')->limit(1)->get();
        if ($order_data) {

            foreach ($order_data as $order_item) {

                $data = $order->showRepository($order_item->sales_order_id, ['customer', 'forwarder', 'detail', 'detail.product']);
                Mail::to($order_item->sales_order_email)->send(new CreateOrderEmail($data));
                $data->sales_order_email_date = date('Y-m-d H:i:s');
                $data->save();
            }
        }

        // $payment = new PaymentRepository();
        // $payment_data = $payment->dataRepository()->whereNull('finance_payment_email_date')->limit(1)->get();
        // if ($payment_data) {

        //     foreach ($payment_data as $payment_item) {
        //         $data = $payment->showRepository($payment_item->finance_payment_id);
        //         Mail::to($payment_item->finance_payment_email)->send(new CreateOrderEmail($data));
        //         $data->sales_order_email_date = date('Y-m-d H:i:s');
        //         $data->save();
        //     }
        // }


        // Mail::send('emails.send', ['title' => 'New System Copy', 'content' => config()->get('app.url')], function ($message) {
        //     $message->subject('New System Laravel');
        //     $message->from('me@itoktoni.com', 'Laravel System');
        //     $message->to('itok.toni@gmail.com');
        // });

        $this->info('The system has been sent successfully!');
    }
}
