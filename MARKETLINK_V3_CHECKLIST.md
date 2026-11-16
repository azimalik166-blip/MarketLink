# MarketLink V3 – Rebuilt Stability Patch

This patch was rebuilt against the Laravel 12 / MySQL schema used by the earlier MarketLink build.

## Issues checked and repaired

- Dark mode now applies at the document root and covers cards, forms, modals, tables, pagination, utility text, cart, reviews and dashboard surfaces.
- Theme preference persists in localStorage and avoids the initial white flash.
- Footer uses a viewport-width escape rule so it remains full-width even if a child page has container-level layout constraints.
- Admin dashboard markup was rewritten with balanced containers to prevent the footer being nested inside the dashboard container.
- Cart is visible only to customers; farmers/admins no longer get a 403 by clicking a cart icon.
- Reports controller/view variable mismatch (`orders` vs `orderCount`) fixed.
- Admin users can activate/suspend customers and approve/suspend farmers.
- Admin category delete and announcement delete were added with safe checks.
- Admin market edit controls added.
- Direct single-product reservation now uses real farmer pickup slots instead of free-text fake time slots.
- Cart checkout now verifies farmer + market against the selected pickup slot and enforces slot capacity.
- Pickup-slot overlap validation added.
- Customer order detail supports reorder and per-product review forms.
- Review stars are clickable 1–5 and validate before submit.
- Farmer order detail and order list were rewritten to avoid Blade parse/HTML nesting issues.
- Missing farmer product inventory view is included.
- Product detail uses Add to Cart and clean review/map sections without `@push/@endpush` in the page view.
- Security headers remain enabled through `bootstrap/app.php`.

## Database

One migration is included:
`database/migrations/2026_09_25_120000_create_pickup_slots_table.php`

Run:
`php artisan migrate`

Do not reset the database.
