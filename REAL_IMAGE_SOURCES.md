# MarketLink real-photo fallback sources

The UI uses existing uploaded product images when present. When a product has no stored image, the new UI falls back to real photographic sources selected for the demo catalog:

- Tomatoes on the Vine — Wikimedia Commons / Unsplash source, CC0 as documented on the Commons file page.
- Freshly harvested mangoes — Wikimedia Commons, CC0.
- Fresh Eggs (Unsplash) — Wikimedia Commons, CC0 archive.
- Fresh carrots — Wikimedia Commons / Unsplash source, CC0 archive.
- Fresh spinach leaves — PublicDomainPictures, public-domain listing.
- Sourdough Bread Loaf — Wikimedia Commons, CC BY 4.0.
- Milk bottle — Wikimedia Commons, CC BY-SA 4.0 (available for future product mapping).
- Fresh coriander — Wikimedia Commons, public domain.

These fallbacks are remote URLs so the local site can display real photographs without changing the database schema; a browser without internet will automatically show the category icon fallback.
