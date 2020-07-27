<?php

namespace Avant\LaravelNovaCurrencyField;

use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;

class FieldServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Nova::serving(function (ServingNova $event) {
            Nova::script('laravel-nova-currency-field', __DIR__.'/../dist/js/field.js');
        });
    }
}
