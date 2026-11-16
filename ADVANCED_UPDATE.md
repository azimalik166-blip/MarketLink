# MarketLink Advanced Update

This update adds the requested modules without changing the existing database schema:

1. Customer dashboard + order timeline/detail
2. Farmer dashboard + sales/stock analytics
3. Notifications + unread/read controls
4. Favorites + advanced product search/filter/sort
5. Reviews + farmer replies
6. OpenStreetMap/Leaflet market maps
7. Expanded admin dashboard, users, reports and moderation
8. Enhanced in-app MarketLink Assistant
9. Responsive UI improvements
10. Security hardening: role approval checks, login/register throttling, security headers, ownership checks and stricter order transitions

## Apply

Copy the contents of this archive over the existing `C:\xampp\htdocs\MarketLink` project, preserving `.env` and `vendor/`.

Then run:

```powershell
cd C:\xampp\htdocs\MarketLink
php artisan optimize:clear
php artisan storage:link
php artisan route:list
php artisan serve
```

No new migration is required for this update; the current orders, favorites, reviews and notifications tables already support these features.

## Demo accounts

- Admin: `admin@marketlink.local` / `Password123!`
- Farmer: `farmer@marketlink.local` / `Password123!`
- Customer: `customer@marketlink.local` / `Password123!`

## Manual test flow

### Customer
1. Login as customer.
2. Explore products and use search/category/market/price/sort filters.
3. Favorite a product.
4. Place an order.
5. Open the order detail and verify the timeline.
6. Cancel a placed/accepted order and verify stock restoration.
7. Use Notifications and mark notifications read.
8. After farmer completes an order, submit a review.

### Farmer
1. Login as farmer.
2. Check dashboard stock, low-stock count and sales chart.
3. Open Incoming Orders.
4. Accept a placed order.
5. Mark it Ready.
6. Mark it Completed.
7. Alternatively decline/cancel and verify stock restoration.
8. Reply to a customer review.

### Admin
1. Login as admin.
2. Review pending/active farmers.
3. Manage markets and categories.
4. Moderate products/reviews.
5. Publish announcements.
6. Open reports and verify order/revenue summaries.

### Security checks
- A customer cannot access another customer's order.
- A farmer cannot modify another farmer's order/product/review.
- Pending/suspended farmers cannot enter farmer-only routes.
- Order transitions are state-checked to prevent duplicate stock restoration.
