<?php

namespace App\Console\Commands;

use Illuminate\Support\Carbon;
use Illuminate\Console\Command;
use Modules\Sales\Dao\Models\Order;

class CancelOrder extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:cancel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This commands to cancel order if order is not paid';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {

        Order::where('sales_order_status', 1)->where('sales_order_created_at', '<', Carbon::now()->subMinutes(1)->toDateTimeString())->limit(100)->update(['sales_order_status' => '0']);
        $this->info('The system has cancel order successfully!');
    }

}
