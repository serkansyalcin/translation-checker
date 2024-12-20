<?php

namespace TranslationChecker\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CheckMissingTranslations extends Command
{
    protected $signature = 'lang:check-missing {--default=en : Default language to compare against}';

    protected $description = 'Checks for missing translations in all language files.';

    public function handle()
    {
        $defaultLang = $this->option('default');
        $defaultLangFiles = [];

        $langPath = resource_path('lang');
        if (File::exists($langPath . '/' . $defaultLang)) {
            $defaultLangFiles = File::allFiles($langPath . '/' . $defaultLang);
        }

        // If there are no language files in the resource path('lang'), let's check the lang folder in the main directory.
        if (empty($defaultLangFiles)) {
            $langPath = base_path('lang');
            if (File::exists($langPath . '/' . $defaultLang)) {
                $defaultLangFiles = File::allFiles($langPath . '/' . $defaultLang);
            }
        }

        $missingTranslations = [];

        foreach ($defaultLangFiles as $file) {
            $relativePath = $file->getRelativePathname();
            $defaultContent = include $file->getRealPath();

            foreach (File::directories($langPath) as $langDir) {
                $lang = basename($langDir);
                if ($lang === $defaultLang) {
                    continue;
                }

                $filePath = $langDir . '/' . $relativePath;
                if (!File::exists($filePath)) {
                    $missingTranslations[$lang][$relativePath] = 'File is missing.';
                    continue;
                }

                $translatedContent = include $filePath;
                $missingKeys = $this->findMissingKeys($defaultContent, $translatedContent);

                if (!empty($missingKeys)) {
                    $missingTranslations[$lang][$relativePath] = $missingKeys;
                }
            }
        }

        if (empty($missingTranslations)) {
            $this->info('No missing translations found.');
        } else {
            foreach ($missingTranslations as $lang => $files) {
                $this->warn("Missing translations in [$lang]:");
                foreach ($files as $file => $missingKeys) {
                    if (is_string($missingKeys)) {
                        $this->line("- $file: $missingKeys");
                    } else {
                        $this->line("- $file:");
                        foreach ($missingKeys as $key) {
                            $this->line("  - $key");
                        }
                    }
                }
            }
        }
    }

    private function findMissingKeys(array $defaultContent, array $translatedContent, $prefix = '')
    {
        $missingKeys = [];

        foreach ($defaultContent as $key => $value) {
            $fullKey = $prefix ? "$prefix.$key" : $key;

            if (is_array($value)) {
                $subKeys = $this->findMissingKeys($value, $translatedContent[$key] ?? [], $fullKey);
                $missingKeys = array_merge($missingKeys, $subKeys);
            } elseif (!array_key_exists($key, $translatedContent)) {
                $missingKeys[] = $fullKey;
            }
        }

        return $missingKeys;
    }
}