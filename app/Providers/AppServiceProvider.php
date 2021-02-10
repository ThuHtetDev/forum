<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
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
        //

        \View::composer('*',function($v){

            $channels = \Cache::rememberForever('channels',function(){
                return \App\Channel::all();
            });
            $v->with('channels',$channels);
        });
        // \View::share('channels',\App\Channel::all());
    }
}
