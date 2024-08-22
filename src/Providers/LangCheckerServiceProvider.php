<?php

namespace TranslationChecker\LangChecker\Providers;

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
            \TranslationCchecker\LangChecker\Console\Commands\CheckMissingTranslations::class,
        ]);
    }
}
