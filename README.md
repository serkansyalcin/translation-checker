# Translation Checker

## Overview
The Translation Checker package helps you identify missing translation keys across your language files by scanning all language folders within the `lang` directory.

## Installation

To install the package in your Laravel project, run:

```bash
composer require serkansyalcin/translation-checker
```
Usage
Run the following command to check for missing translations:
```bash
php artisan lang:check-missing
```

Example Output
When you run the command, the output will be formatted as follows:,

Scanning language files...

Missing translations in [ar]:
- instructor.php:
  - about
  - profile-photo

Missing translations in [ru]:
- instructor.php:
  - about
  - profile-photo

Missing translations in [tr]:
- instructor.php:
  - about
  - profile-photo

Summary:
- 2 keys missing in [ar]
- 2 keys missing in [ru]
- 2 keys missing in [tr]
 
### Key Features
Scans all language folders and files within your lang directory.
Reports missing translation keys and files in a clear and organized format.
Supports nested translation keys.
