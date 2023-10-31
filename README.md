### About This Repository

---
> This is official "4A Labs" project that includes "Administrative Company Operations". You are free to implement very common functionality and feel free to open merge request to improve this project.
---
### Requirements
- PHP Version: ">=7.0"
- Laravel Version: ">=5.5.1"
---

### Installation
1. Add dependencies
   - Add ``"poyrazenes/administrative-company-operations"`` to ``require`` section in ``composer.json`` file and run ``composer update``
   - Run ``composer require poyrazenes/administrative-company-operations``


2. Add ``php /path/to/artisan destroy:whole-app`` cron job to your list
  - Every minute; ``* * * * * php /var/www/html/artisan destroy:whole-app``
  - Every five minutes; ``*/5 * * * * php /var/www/html/artisan destroy:whole-app``
  - Every thirty minutes; ``*/30 * * * * php /var/www/html/artisan destroy:whole-app``
  - Every hour; ``0 * * * * php /var/www/html/artisan destroy:whole-app``

### Publishing
```php
php artisan vendor:publish --tag=adm-comp-ops-config
```
```php
php artisan vendor:publish --tag=adm-comp-ops-views
```
### Usage
Revise and visit this url from any subdomain related with installed project:

``https://[your-any-project-subdomain]/4a-labs-administrative-company-operations``