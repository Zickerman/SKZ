<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Orchid\Screen\TD;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        TD::macro('cutString', function ($length) {

            $column = $this->column;

            $this->render(function ($datum) use ($column, $length) {
                return mb_strimwidth($datum->$column, 0, $length, '...');
            });

            return $this;
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
