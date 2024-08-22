<?php

namespace TranslationChecker\Providers;

use Illuminate\Support\ServiceProvider;

class LangCheckerServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        $this->commands([
            TranslationChecker\Providers\LangCheckerServiceProvider::class,
        ]);
    }
}
