<?php

namespace TranslationCchecker\LangChecker\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CheckMissingTranslations extends Command
{
    protected $signature = 'lang:check-missing';

    protected $description = 'Checks for missing translations in all language files.';

    public function handle()
    {
        $defaultLang = 'en';
        $langPath = resource_path('lang');
        $defaultLangFiles = File::allFiles($langPath . '/' . $defaultLang);

        $missingTranslations = [];

        foreach ($defaultLangFiles as $file) {
            $relativePath = $file->getRelativePathname();

            // Her dil klasörünü kontrol et
            foreach (File::directories($langPath) as $langDir) {
                $lang = basename($langDir);
                if ($lang === $defaultLang) {
                    continue;
                }

                $filePath = $langDir . '/' . $relativePath;
                if (!File::exists($filePath)) {
                    $missingTranslations[$lang][] = $relativePath;
                }
            }
        }

        if (empty($missingTranslations)) {
            $this->info('No missing translations found.');
        } else {
            foreach ($missingTranslations as $lang => $files) {
                $this->warn("Missing translations in [$lang]:");
                foreach ($files as $file) {
                    $this->line("- $file");
                }
            }
        }
    }
}
