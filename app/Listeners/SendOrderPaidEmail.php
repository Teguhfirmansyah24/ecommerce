<?php

// app/Listeners/SendOrderPaidEmail.php

namespace App\Listeners;

use App\Events\OrderPaidEvent;
use App\Mail\OrderPaid;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendOrderPaidEmail implements ShouldQueue
{
    // Retry jika gagal
    public $tries = 3;

    public function handle(OrderPaidEvent $event): void
    {
        // Kirim email ke user
        Mail::to($event->order->user->email)
            ->send(new OrderPaid($event->order));
    }
}
