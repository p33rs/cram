<?php
namespace cram\validators;
use Illuminate\Support\ServiceProvider;

class ValidatorServiceProvider extends ServiceProvider {

    protected $defer = true;

    public function provides()
    {
        return ['cram\Validation'];
    }

    public function register()
    {
        $this->app->bind('cram\Validation', function()
        {
            return new ValidatorLocator();
        });
    }

}