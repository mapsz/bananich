<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

use Illuminate\Auth\Events\Failed;
use App\Listeners\LogFailedAuthenticationAttempt;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        
        Failed::class => [
            LogFailedAuthenticationAttempt::class,
        ],

        //Order
        'App\Events\OrderSuccess' => [
            'App\Listeners\addBonus',
        ],
        'App\Events\OrderSuccessCancel' => [
            'App\Listeners\cancelBonus',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
