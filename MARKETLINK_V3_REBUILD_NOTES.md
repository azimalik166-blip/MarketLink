# MarketLink V3 Rebuilt – Stability Patch

This overlay is intended for the existing MarketLink Laravel 12 project. It does not include or replace `.env`, `vendor`, or the existing base migrations.

Before copying, back up `C:\xampp\htdocs\MarketLink`.

Copy/merge this package into the project root and allow file replacement. Then run:

```powershell
cd C:\xampp\htdocs\MarketLink
php artisan migrate
php artisan view:clear
php artisan optimize:clear
php artisan route:list
php artisan serve
```

The only new migration is `2026_09_25_120000_create_pickup_slots_table.php`.

Key rebuilt areas: complete dark theme, full-width footer, customer cart/checkout, pickup slot capacity, order state validation, customer reorder/reviews, farmer inventory/pickup slots, farmer public profile, admin management/report exports, notifications, assistant guards, and security headers.

Do not reset the database. Do not overwrite `.env`.
