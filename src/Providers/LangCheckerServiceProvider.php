<?php

namespace TranslationChecker\Providers;

use Illuminate\Support\ServiceProvider;
use TranslationChecker\Console\Commands\CheckMissingTranslations;


class LangCheckerServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        $this->commands([
            CheckMissingTranslations::class,
        ]);
    }
}
