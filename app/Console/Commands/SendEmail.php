<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
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
        foreach ($order->dataRepository()->whereNull('sales_order_email_date')->limit(1)->get() as $value) {

            $data = $order->showRepository($value->sales_order_id, ['customer', 'forwarder', 'detail', 'detail.product']);
            Mail::to($value->sales_order_email)->send(new TestingOrderEmail($data));
            $data->sales_order_email_date = date('Y-m-d H:i:s');
            $data->save();
        }

        // Mail::send('emails.send', ['title' => 'New System Copy', 'content' => config()->get('app.url')], function ($message) {
        //     $message->subject('New System Laravel');
        //     $message->from('me@itoktoni.com', 'Laravel System');
        //     $message->to('itok.toni@gmail.com');
        // });

        $this->info('The system has been sent successfully!');
    }
}
