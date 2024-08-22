# Browsing Language Files
### You can scan the files and keys inside by reading all the language folders in the lang folder.

#### Running the Command

```php
php artisan lang:check-missing
```
**When you run this command, the result will look like this:**
Missing translations in [fr]:
- auth.php:
  - login
  - password
- validation.php:
  - required.name
  - required.email
Missing translations in [de]:
- messages.php: File is missing.
