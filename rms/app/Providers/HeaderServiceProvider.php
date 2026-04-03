<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Message;

class HeaderServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Using Closure based composers...
        View::composer('layouts.header', function ($view) {
            $emails = Message::where('receiver_id', Auth::user()->id)->where('status','!=',null)->count();
            $view->with([
                'emails ' => $emails,
                
            ]);
        });
    }
}