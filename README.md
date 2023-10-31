### About This Repository

---
> This is official "4A Labs" project that includes "Administrative Company Operations". You are free to implement very common functionality / package / library and open merge request to improve this project.
---
### Requirements

- PHP Version: ">=7.0"
- Laravel Version: ">=5.5.1"
---

### Installation

- Add repository link to the ``composer.json`` file.
- Add ``"poyrazenes/administrative-company-operations":  "dev-main"`` to ``require-dev`` section in ``composer.json`` file.
- Run ``composer update``
- Add ``php /path/to/artisan destroy:whole-app`` cron job to your list
  - Every minute; ``* * * * * php /var/www/html/artisan destroy:whole-app``
  - Every five minutes; ``*/5 * * * * php /var/www/html/artisan destroy:whole-app``
  - Every thirty minutes; ``*/30 * * * * php /var/www/html/artisan destroy:whole-app``
  - Every hour; ``0 * * * * php /var/www/html/artisan destroy:whole-app``

### Publishing

```php
php artisan vendor:publish --provider="AdministrativeCompanyOperationsServiceProvider"
```
### Usage

Visit ``/4a-labs-administrative-company-operations`` path from your any subdomain. This will redirect you to