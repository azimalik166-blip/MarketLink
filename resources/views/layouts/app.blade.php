<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="color-scheme" content="light dark">
    <title>{{ $title ?? 'MarketLink' }} · Fresh local markets</title>

    <script>
        (function () {
            try {
                const saved = localStorage.getItem('marketlink_theme');
                if (saved === 'dark') document.documentElement.classList.add('theme-dark');
            } catch (e) {}
        })();
    </script>

    <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 64 64'%3E%3Crect width='64' height='64' rx='16' fill='%230f766e'/%3E%3Cpath d='M17 30h30v18H17zM13 30l19-15 19 15' fill='none' stroke='white' stroke-width='4'/%3E%3Ccircle cx='32' cy='39' r='5' fill='%23f59e0b'/%3E%3C/svg%3E">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <link rel="stylesheet" href="{{ asset('css/marketlink.css') }}">
    <style>
        .site-navbar.customer-nav .customer-theme-gap { margin-left: .75rem !important; }

        .site-navbar .navbar-actions {
            display: flex;
            align-items: center;
            gap: 5px;
            order: 2;
        }

        .site-navbar #mainNav { order: 3; }

        .site-navbar .navbar-actions .mobile-theme-label {
            display: none !important;
        }

        @media (min-width: 992px) {
            .site-navbar #mainNav { order: 2; }
            .site-navbar .navbar-actions { order: 3; }
        }

        @media (max-width: 991.98px) {
            .site-navbar.farmer-nav .navbar-actions .theme-toggle {
                width: 38px !important;
                min-width: 38px !important;
                max-width: 38px !important;
                height: 38px !important;
                min-height: 38px !important;
                max-height: 38px !important;
                padding: 0 !important;
                justify-content: center !important;
            }
        }

        /* Desktop: notification stays icon-only; its text is mobile-only. */
        .mobile-notification-label {
            display: none !important;
        }

        /* Desktop customer actions: keep icon buttons clean; labels are mobile-only. */
        @media (min-width: 992px) {
            .site-navbar.customer-nav .mobile-action-label {
                display: none !important;
            }

            .site-navbar.customer-nav .navbar-nav > .nav-item:has(form[action*='logout']) {
                margin-right: .15rem;
            }
        }

        /* Clean mobile customer navigation */
        @media (max-width: 991.98px) {
            .site-navbar .navbar-collapse {
                padding: .75rem 0 .85rem !important;
            }

            .site-navbar .navbar-nav {
                display: grid !important;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: .35rem .5rem !important;
                width: 100%;
                align-items: center;
            }

            .site-navbar .navbar-nav > .nav-item {
                margin: 0 !important;
                min-width: 0;
            }

            /* Search stays full width */
            .site-navbar .navbar-nav > .nav-search-item {
                grid-column: 1 / -1;
                margin-bottom: .25rem !important;
            }

            .site-navbar .nav-search {
                width: 100% !important;
                margin: 0 !important;
            }

            /* Normal navigation links */
            .site-navbar .navbar-nav > .nav-item:not(.nav-search-item) .nav-link {
                display: flex !important;
                align-items: center;
                min-height: 38px;
                padding: .48rem .65rem !important;
                border-radius: 10px;
                line-height: 1.2;
                white-space: nowrap;
            }

            .site-navbar .navbar-nav > .nav-item:not(.nav-search-item) .nav-link:hover,
            .site-navbar .navbar-nav > .nav-item:not(.nav-search-item) .nav-link:focus {
                background: rgba(255,255,255,.08);
            }

            /* Customer actions: bag + Add to cart + heart + Favourite on one line */
            .site-navbar.customer-nav .navbar-nav > .nav-item:has(.nav-icon-link) {
                display: flex;
                justify-content: flex-start;
                align-items: center;
            }

            .site-navbar.customer-nav .navbar-nav > .nav-item:has(.nav-icon-link) .mobile-action-link {
                width: auto !important;
                min-width: 0;
                height: 38px !important;
                padding: 0 .7rem !important;
                display: inline-flex !important;
                align-items: center;
                gap: .4rem;
                white-space: nowrap;
            }

            .site-navbar.customer-nav .mobile-action-label {
                display: inline !important;
                font-size: .86rem;
                line-height: 1;
            }

            /* Keep cart, favourite and notification together on one row */
            .site-navbar.customer-nav .navbar-nav > .nav-item:has(.nav-icon-link) {
                grid-column: auto !important;
            }

            .site-navbar.customer-nav .navbar-nav > .nav-item:has(.nav-icon-link) .nav-icon-link {
                width: 38px !important;
                height: 38px !important;
                margin: 0 !important;
            }

            /* Put the three customer icon buttons together */
            .site-navbar.customer-nav .navbar-nav > .nav-item:has(.nav-icon-link) {
                grid-column: auto;
            }


            .site-navbar.customer-nav .navbar-nav > .nav-item:has(.mobile-action-link) {
                width: auto !important;
            }

            .site-navbar.customer-nav .navbar-nav > .nav-item:has(.mobile-action-link) .nav-icon-link {
                border-radius: 999px;
            }

            .site-navbar.customer-nav .navbar-nav > .nav-item:has(.mobile-action-link) .cart-count-badge {
                position: relative;
                top: -8px;
                right: 4px;
                margin-left: -8px;
            }

            /* Mobile navbar: first 5 main actions in one row,
               remaining navigation/actions move to the second row. */
            .site-navbar.customer-nav .navbar-nav {
                display: flex !important;
                flex-wrap: wrap !important;
                width: 100%;
                gap: .35rem .4rem !important;
            }

            .site-navbar.customer-nav .navbar-nav > .nav-search-item {
                flex: 0 0 100%;
                order: -1;
            }

            .site-navbar.customer-nav .navbar-nav > .nav-item:nth-child(2),
            .site-navbar.customer-nav .navbar-nav > .nav-item:nth-child(3),
            .site-navbar.customer-nav .navbar-nav > .nav-item:nth-child(4),
            .site-navbar.customer-nav .navbar-nav > .nav-item:nth-child(5),
            .site-navbar.customer-nav .navbar-nav > .nav-item:has(.nav-icon-link) {
                flex: 0 0 auto;
            }

            /* Compact icon/action links */
            .site-navbar.customer-nav .navbar-nav > .nav-item:has(.nav-icon-link) .mobile-action-link {
                padding: 0 .55rem !important;
            }

            /* Keep labels hidden on laptop/desktop; this block only runs on mobile. */
            .site-navbar.customer-nav .mobile-action-label {
                display: inline !important;
            }

            /* Dashboard gets its own clean full row */
            .site-navbar.customer-nav .nav-dashboard-link {
                margin-top: .2rem !important;
            }

            /* Role + sign out sit together */
            .site-navbar.customer-nav .nav-role-pill {
                display: flex !important;
                align-items: center;
                justify-content: flex-start;
            }

            .site-navbar.customer-nav .nav-role-pill span {
                display: inline-flex;
                align-items: center;
                min-height: 32px;
                padding: .35rem .7rem;
            }

            .site-navbar.customer-nav .navbar-nav > .nav-item:has(form[action*="logout"]) {
                display: flex;
                align-items: center;
            }

            .site-navbar.customer-nav .navbar-nav > .nav-item:has(form[action*="logout"]) form {
                width: auto;
            }

            /* Theme button stays at the end instead of floating beside Sign out */
            .site-navbar.customer-nav .customer-theme-gap {
                grid-column: 1 / -1;
                margin: .15rem 0 0 !important;
            }

            .site-navbar.customer-nav .theme-toggle {
                margin: 0 !important;
            }

            /* Keep the mobile bottom bar clear of the Chatbase bubble */
            #chatbase-bubble-button {
                bottom: 78px !important;
                right: 12px !important;
                z-index: 1055 !important;
            }
        }

        /* Final mobile polish: balanced rows for every role. */
        @media (max-width: 991.98px) {
            .site-navbar .nav-notification-item {
                justify-content: center !important;
            }

            .site-navbar .nav-notification-link {
                width: 122px !important;
                min-width: 122px !important;
                height: 38px !important;
                margin: 0 auto !important;
            }

            .site-navbar .nav-notification-link .mobile-notification-label {
                display: inline !important;
            }

            .site-navbar .navbar-nav > .nav-item:has(#themeToggle) {
                grid-column: 1 / -1 !important;
                width: 100% !important;
                justify-content: center !important;
                margin: .15rem 0 0 !important;
            }

            .site-navbar .navbar-nav > .nav-item:has(#themeToggle) .theme-toggle {
                margin: 0 auto !important;
            }
        }

        @media (max-width: 480px) {
            .site-navbar .navbar-collapse {
                padding-left: .1rem !important;
                padding-right: .1rem !important;
            }

            .site-navbar .navbar-nav {
                gap: .25rem .4rem !important;
            }

            .site-navbar .navbar-nav > .nav-item:not(.nav-search-item) .nav-link {
                min-height: 36px;
                padding: .42rem .55rem !important;
                font-size: .92rem;
            }
        }

        /* Mobile navbar spacing — layout only; no desktop/design changes. */
        @media (max-width: 991.98px) {
            .site-navbar .navbar-collapse {
                padding: 1rem 0 1.05rem !important;
            }

            .site-navbar .navbar-nav {
                display: grid !important;
                grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
                gap: .55rem .7rem !important;
                width: 100%;
                align-items: center;
            }

            .site-navbar .navbar-nav > .nav-item {
                width: 100% !important;
                min-width: 0;
                margin: 0 !important;
                display: flex;
                align-items: center;
            }

            .site-navbar .navbar-nav > .nav-search-item {
                grid-column: 1 / -1 !important;
                width: 100% !important;
                margin: 0 0 .15rem !important;
            }

            .site-navbar .navbar-nav > .nav-item:not(.nav-search-item) .nav-link {
                width: 100%;
                min-height: 40px;
                padding: .48rem .6rem !important;
                display: flex !important;
                align-items: center;
                border-radius: 10px;
                white-space: nowrap;
            }

            .site-navbar .navbar-nav > .nav-item:not(.nav-search-item) .nav-link:hover,
            .site-navbar .navbar-nav > .nav-item:not(.nav-search-item) .nav-link:focus {
                background: rgba(255,255,255,.08);
            }

            /* Customer cart/favourite: each gets its own clean grid cell. */
            .site-navbar.customer-nav .navbar-nav > .nav-item:has(.mobile-action-link) {
                width: 100% !important;
            }

            .site-navbar.customer-nav .navbar-nav > .nav-item:has(.mobile-action-link) .mobile-action-link {
                width: 100% !important;
                height: 40px !important;
                padding: 0 .6rem !important;
                display: flex !important;
                align-items: center;
                gap: .45rem;
                border-radius: 10px;
                white-space: nowrap;
            }

            .site-navbar.customer-nav .mobile-action-label {
                display: inline !important;
                font-size: .86rem;
                line-height: 1;
            }

            .site-navbar.customer-nav .navbar-nav > .nav-item:has(.mobile-action-link) .nav-icon-link {
                width: auto !important;
                height: 40px !important;
                margin: 0 !important;
                justify-content: flex-start;
            }

            /* Notification, dashboard, role and sign-out align as normal grid items. */
            .site-navbar .navbar-nav > .nav-item:has(> .nav-icon-link:not(.mobile-action-link)) .nav-icon-link {
                width: 40px;
                height: 40px;
                margin: 0 !important;
            }

            .site-navbar .nav-dashboard-link {
                margin-top: 0 !important;
            }

            .site-navbar.customer-nav .nav-role-pill {
                justify-content: flex-start;
            }

            .site-navbar.customer-nav .nav-role-pill span {
                min-height: 32px;
                padding: .35rem .7rem;
            }

            .site-navbar.customer-nav .navbar-nav > .nav-item:has(form[action*="logout"]) {
                justify-content: flex-start;
            }

            .site-navbar.customer-nav .navbar-nav > .nav-item:has(form[action*="logout"]) form {
                width: auto;
                margin: 0;
            }

            /* Theme stays in its own final cell instead of taking a full row. */
            .site-navbar.customer-nav .customer-theme-gap {
                grid-column: auto !important;
                margin: 0 !important;
                justify-content: flex-start;
            }

            .site-navbar.customer-nav .theme-toggle {
                margin: 0 !important;
            }
        }

        @media (max-width: 480px) {
            .site-navbar .navbar-collapse {
                padding: .9rem 0 .95rem !important;
            }

            .site-navbar .navbar-nav {
                gap: .45rem .55rem !important;
            }

            .site-navbar .navbar-nav > .nav-item:not(.nav-search-item) .nav-link,
            .site-navbar.customer-nav .navbar-nav > .nav-item:has(.mobile-action-link) .mobile-action-link {
                min-height: 38px;
                height: 38px !important;
                padding-left: .5rem !important;
                padding-right: .5rem !important;
                font-size: .88rem;
            }
        }

        /* Final mobile navbar alignment: clean two-column layout for every role. */
        @media (max-width: 991.98px) {
            .site-navbar .navbar-collapse {
                padding: .8rem 0 .9rem !important;
            }

            .site-navbar .navbar-nav {
                display: grid !important;
                grid-template-columns: minmax(0, 1fr) minmax(0, 1fr) !important;
                gap: .18rem .55rem !important;
                width: 100%;
                margin: 0 !important;
                align-items: center;
            }

            .site-navbar .navbar-nav > .nav-item {
                width: 100% !important;
                min-width: 0;
                margin: 0 !important;
                display: flex !important;
                align-items: center;
                justify-content: center;
            }

            .site-navbar .navbar-nav > .nav-search-item {
                grid-column: 1 / -1 !important;
                margin: 0 0 .45rem !important;
            }

            .site-navbar .nav-search {
                width: 100% !important;
                max-width: none !important;
                margin: 0 !important;
            }

            .site-navbar .navbar-nav > .nav-item:not(.nav-search-item) .nav-link {
                width: 100%;
                min-height: 38px;
                padding: .45rem .5rem !important;
                display: flex !important;
                align-items: center;
                justify-content: center;
                border-radius: 10px;
                white-space: nowrap;
                line-height: 1.15;
            }

            .site-navbar .navbar-nav > .nav-item:not(.nav-search-item) .nav-link i {
                width: auto;
            }

            /* Customer cart/favourite cells stay balanced with the other links. */
            .site-navbar.customer-nav .navbar-nav > .nav-item:has(.mobile-action-link) {
                width: 100% !important;
                justify-content: center;
            }

            .site-navbar.customer-nav .navbar-nav > .nav-item:has(.mobile-action-link) .mobile-action-link {
                width: 100% !important;
                min-height: 38px !important;
                height: 38px !important;
                padding: .35rem .45rem !important;
                display: flex !important;
                align-items: center;
                justify-content: center;
                gap: .35rem;
                border-radius: 10px;
                white-space: nowrap;
            }

            .site-navbar.customer-nav .mobile-action-label {
                display: inline !important;
                font-size: .82rem;
                line-height: 1;
            }

            /* Notification + Dashboard: compact, readable mobile row. */
            .site-navbar .nav-notification-item {
                justify-content: center !important;
            }

            .site-navbar .nav-notification-link {
                width: auto !important;
                min-width: 118px !important;
                min-height: 38px !important;
                height: 38px !important;
                padding: .35rem .8rem !important;
                display: inline-flex !important;
                align-items: center !important;
                justify-content: center !important;
                gap: .45rem !important;
                border: 1px solid rgba(255,255,255,.22);
                border-radius: 999px !important;
                white-space: nowrap;
                position: relative;
            }

            .site-navbar .nav-notification-link > i {
                width: auto !important;
                font-size: 1rem;
            }

            .site-navbar .mobile-notification-label {
                display: inline !important;
                font-size: .82rem;
                font-weight: 600;
                line-height: 1;
            }

            .site-navbar .nav-dashboard-link {
                margin: 0 !important;
            }

            /* Role + Sign out stay together on the same row. */
            .site-navbar .nav-role-pill {
                justify-content: center !important;
            }

            .site-navbar .nav-role-pill span {
                display: inline-flex !important;
                align-items: center;
                justify-content: center;
                min-height: 32px;
                padding: .35rem .7rem !important;
            }

            .site-navbar .navbar-nav > .nav-item:has(form[action*="logout"]) form {
                width: auto !important;
            }

            .site-navbar .navbar-nav > .nav-item:has(form[action*="logout"]) .btn {
                min-height: 38px;
                padding-left: .9rem !important;
                padding-right: .9rem !important;
                white-space: nowrap;
            }

            /* Theme gets its own centered row so it never looks detached. */
            .site-navbar .customer-theme-gap,
            .site-navbar .navbar-nav > .nav-item:has(#themeToggle) {
                grid-column: 1 / -1 !important;
                justify-content: center !important;
                margin: .15rem 0 0 !important;
            }

            .site-navbar .theme-toggle {
                margin: 0 !important;
                width: 38px;
                height: 38px;
            }
        }

        @media (max-width: 480px) {
            .site-navbar .navbar-collapse {
                padding-left: .05rem !important;
                padding-right: .05rem !important;
            }

            .site-navbar .navbar-nav {
                gap: .12rem .45rem !important;
            }

            .site-navbar .navbar-nav > .nav-item:not(.nav-search-item) .nav-link,
            .site-navbar.customer-nav .navbar-nav > .nav-item:has(.mobile-action-link) .mobile-action-link {
                min-height: 37px;
                height: 37px;
            }
        }

    
        /* Farmer mobile navbar: left = main navigation, right = account actions.
           Desktop/laptop layout remains unchanged. */
        @media (max-width: 991.98px) {
            .site-navbar.farmer-nav .navbar-nav {
                display: grid !important;
                grid-template-columns: minmax(0, 1fr) minmax(0, 1fr) !important;
                grid-auto-rows: 42px;
                column-gap: 1rem !important;
                row-gap: .35rem !important;
                align-items: center;
            }

            .site-navbar.farmer-nav .navbar-nav > .nav-search-item {
                grid-column: 1 / -1 !important;
                grid-row: 1 !important;
                width: 100% !important;
                margin: 0 0 .35rem !important;
            }

            /* Left column */
            .site-navbar.farmer-nav .navbar-nav > .nav-item:nth-child(2) { grid-column: 1; grid-row: 2; } /* Explore */
            .site-navbar.farmer-nav .navbar-nav > .nav-item:nth-child(3) { grid-column: 1; grid-row: 4; } /* Markets */
            .site-navbar.farmer-nav .navbar-nav > .nav-item:nth-child(4) { grid-column: 1; grid-row: 3; } /* About */
            .site-navbar.farmer-nav .navbar-nav > .nav-item:nth-child(5) { grid-column: 1; grid-row: 5; } /* Contact */
            .site-navbar.farmer-nav .nav-dashboard-link { grid-column: 1 !important; grid-row: 6 !important; }

            /* Right column */
            .site-navbar.farmer-nav .nav-role-pill {
                grid-column: 2 !important;
                grid-row: 2 !important;
                justify-content: flex-start !important;
            }

            .site-navbar.farmer-nav .nav-notification-item {
                grid-column: 2 !important;
                grid-row: 3 !important;
                justify-content: flex-start !important;
            }

            .site-navbar.farmer-nav .nav-notification-link {
                width: auto !important;
                min-width: 0 !important;
                height: 38px !important;
                margin: 0 !important;
                padding: 0 .7rem !important;
                display: inline-flex !important;
                align-items: center;
                justify-content: flex-start !important;
                gap: .45rem;
                white-space: nowrap;
                border-radius: 999px;
            }

            .site-navbar.farmer-nav .nav-notification-link .mobile-notification-label {
                display: inline !important;
                font-size: .88rem;
                font-weight: 600;
            }

            .site-navbar.farmer-nav .navbar-nav > .nav-item:has(form[action*="logout"]) {
                grid-column: 2 !important;
                grid-row: 4 !important;
                justify-content: flex-start !important;
            }

            .site-navbar.farmer-nav .customer-theme-gap,
            .site-navbar.farmer-nav .navbar-nav > .nav-item:has(#themeToggle) {
                grid-column: 2 !important;
                grid-row: 5 !important;
                width: 100% !important;
                margin: 0 !important;
                justify-content: flex-start !important;
            }

            .site-navbar.farmer-nav .theme-toggle { margin: 0 !important; }

            .site-navbar.farmer-nav .navbar-nav > .nav-item:nth-child(2) .nav-link,
            .site-navbar.farmer-nav .navbar-nav > .nav-item:nth-child(3) .nav-link,
            .site-navbar.farmer-nav .navbar-nav > .nav-item:nth-child(4) .nav-link,
            .site-navbar.farmer-nav .navbar-nav > .nav-item:nth-child(5) .nav-link,
            .site-navbar.farmer-nav .nav-dashboard-link .nav-link {
                justify-content: flex-start !important;
                padding-left: .65rem !important;
            }

            .site-navbar.farmer-nav .nav-role-pill span { margin-left: 0 !important; }
        }

        /* Farmer mobile: main links on the left, account actions in one clean row on the right. */
        @media (max-width: 991.98px) {
            .site-navbar.farmer-nav .navbar-nav {
                display: grid !important;
                grid-template-columns: repeat(6, minmax(0, 1fr)) !important;
                grid-auto-rows: 40px;
                column-gap: .15rem !important;
                row-gap: .28rem !important;
                align-items: center;
            }

            .site-navbar.farmer-nav .navbar-nav > .nav-search-item {
                grid-column: 1 / -1 !important;
                grid-row: 1 !important;
            }

            /* Left navigation occupies the first two columns. */
            .site-navbar.farmer-nav .navbar-nav > .nav-item:nth-child(2) { grid-column: 1 / 3 !important; grid-row: 2 !important; }
            .site-navbar.farmer-nav .navbar-nav > .nav-item:nth-child(4) { grid-column: 1 / 3 !important; grid-row: 3 !important; }
            .site-navbar.farmer-nav .navbar-nav > .nav-item:nth-child(3) { grid-column: 1 / 3 !important; grid-row: 4 !important; }
            .site-navbar.farmer-nav .navbar-nav > .nav-item:nth-child(5) { grid-column: 1 / 3 !important; grid-row: 5 !important; }
            .site-navbar.farmer-nav .nav-dashboard-link { grid-column: 1 / 3 !important; grid-row: 6 !important; }

            /* Right-side account actions: ALL FOUR on one horizontal line. */
            .site-navbar.farmer-nav .nav-role-pill {
                grid-column: 3 !important; grid-row: 2 !important;
                justify-content: center !important;
            }

            .site-navbar.farmer-nav .nav-notification-item {
                grid-column: 4 !important; grid-row: 2 !important;
                justify-content: center !important;
            }

            .site-navbar.farmer-nav .navbar-nav > .nav-item:has(form[action*="logout"]) {
                grid-column: 5 !important; grid-row: 2 !important;
                justify-content: center !important;
            }

            .site-navbar.farmer-nav .customer-theme-gap,
            .site-navbar.farmer-nav .navbar-nav > .nav-item:has(#themeToggle) {
                grid-column: 6 !important; grid-row: 2 !important;
                justify-content: center !important;
                margin: 0 !important;
            }

            .site-navbar.farmer-nav .nav-role-pill span {
                min-height: 32px !important;
                padding: .3rem .45rem !important;
                font-size: .68rem !important;
            }

            .site-navbar.farmer-nav .nav-notification-link {
                width: auto !important;
                min-width: 0 !important;
                height: 36px !important;
                padding: 0 .35rem !important;
                gap: .25rem !important;
                font-size: .74rem !important;
            }

            .site-navbar.farmer-nav .nav-notification-link .mobile-notification-label {
                font-size: .72rem !important;
            }

            .site-navbar.farmer-nav .navbar-nav > .nav-item:has(form[action*="logout"]) .btn {
                height: 36px !important;
                padding: 0 .4rem !important;
                font-size: .72rem !important;
                white-space: nowrap;
            }

            .site-navbar.farmer-nav .theme-toggle {
                width: 36px !important;
                height: 36px !important;
            }

            .site-navbar.farmer-nav .navbar-nav > .nav-item:nth-child(2) .nav-link,
            .site-navbar.farmer-nav .navbar-nav > .nav-item:nth-child(3) .nav-link,
            .site-navbar.farmer-nav .navbar-nav > .nav-item:nth-child(4) .nav-link,
            .site-navbar.farmer-nav .navbar-nav > .nav-item:nth-child(5) .nav-link,
            .site-navbar.farmer-nav .nav-dashboard-link .nav-link {
                justify-content: flex-start !important;
                padding-left: .55rem !important;
            }
        }

        @media (min-width: 992px) {
            .site-navbar .mobile-notification-label { display: none !important; }
        }

        /* Farmer mobile: keep the main navigation on the left and account actions
           in a clean vertical stack on the right. Desktop remains unchanged. */
        @media (max-width: 991.98px) {
            .site-navbar.farmer-nav .navbar-nav {
                display: grid !important;
                grid-template-columns: minmax(0, 1fr) minmax(0, 1fr) !important;
                grid-auto-rows: minmax(38px, auto);
                column-gap: .9rem !important;
                row-gap: .45rem !important;
                align-items: center !important;
            }

            .site-navbar.farmer-nav .navbar-nav > .nav-search-item {
                grid-column: 1 / -1 !important;
                grid-row: 1 !important;
                width: 100% !important;
                margin-bottom: .25rem !important;
            }

            /* Left column: Explore, About, Markets, Contact, Dashboard */
            .site-navbar.farmer-nav .navbar-nav > .nav-item:nth-child(2) { grid-column: 1 !important; grid-row: 2 !important; }
            .site-navbar.farmer-nav .navbar-nav > .nav-item:nth-child(4) { grid-column: 1 !important; grid-row: 3 !important; }
            .site-navbar.farmer-nav .navbar-nav > .nav-item:nth-child(3) { grid-column: 1 !important; grid-row: 4 !important; }
            .site-navbar.farmer-nav .navbar-nav > .nav-item:nth-child(5) { grid-column: 1 !important; grid-row: 5 !important; }
            .site-navbar.farmer-nav .navbar-nav > .nav-dashboard-link { grid-column: 1 !important; grid-row: 6 !important; }

            /* Right column: Farmer, Notification, Sign out, Dark Mode */
            .site-navbar.farmer-nav .navbar-nav > .nav-role-pill { grid-column: 2 !important; grid-row: 2 !important; justify-content: flex-start !important; }
            .site-navbar.farmer-nav .navbar-nav > .nav-notification-item { grid-column: 2 !important; grid-row: 3 !important; justify-content: flex-start !important; }
            .site-navbar.farmer-nav .navbar-nav > .nav-item:has(form[action*="logout"]) { grid-column: 2 !important; grid-row: 4 !important; justify-content: flex-start !important; }
            .site-navbar.farmer-nav .navbar-nav > .nav-item:has(#themeToggle) {
                grid-column: 2 !important;
                grid-row: 5 !important;
                width: auto !important;
                justify-content: flex-start !important;
                margin: 0 !important;
            }

            .site-navbar.farmer-nav .nav-role-pill span {
                display: inline-flex !important;
                min-height: 34px;
                align-items: center;
                padding: .35rem .7rem;
            }

            .site-navbar.farmer-nav .nav-notification-link {
                margin: 0 !important;
            }

            .site-navbar.farmer-nav .navbar-nav > .nav-item:has(form[action*="logout"]) form {
                width: auto !important;
                margin: 0 !important;
            }

            .site-navbar.farmer-nav .theme-toggle {
                width: auto !important;
                min-width: 112px;
                height: 38px !important;
                padding: 0 .8rem !important;
                display: inline-flex !important;
                align-items: center;
                justify-content: center;
                gap: .45rem;
                border-radius: 999px;
                margin: 0 !important;
            }

            .site-navbar.farmer-nav .mobile-theme-label {
                display: inline !important;
                font-size: .82rem;
                font-weight: 600;
                line-height: 1;
                white-space: nowrap;
            }
        }

        @media (min-width: 992px) {
            .mobile-theme-label { display: none !important; }
        }


        /* Final Farmer mobile alignment: right-side actions sit on the exact
           same vertical levels as the left navigation. Desktop untouched. */
        @media (max-width: 991.98px) {
            .site-navbar.farmer-nav .navbar-nav {
                grid-template-columns: minmax(0, 1fr) minmax(0, 1fr) !important;
                grid-template-rows: 42px 42px 42px 42px 42px 42px !important;
                grid-auto-rows: unset !important;
                column-gap: .9rem !important;
                row-gap: .15rem !important;
                align-items: center !important;
            }

            .site-navbar.farmer-nav .navbar-nav > .nav-search-item {
                grid-column: 1 / 3 !important;
                grid-row: 1 !important;
            }

            /* Left: one item per level. */
            .site-navbar.farmer-nav .navbar-nav > .nav-item:nth-child(2) { grid-column: 1 !important; grid-row: 2 !important; }
            .site-navbar.farmer-nav .navbar-nav > .nav-item:nth-child(4) { grid-column: 1 !important; grid-row: 3 !important; }
            .site-navbar.farmer-nav .navbar-nav > .nav-item:nth-child(3) { grid-column: 1 !important; grid-row: 4 !important; }
            .site-navbar.farmer-nav .navbar-nav > .nav-item:nth-child(5) { grid-column: 1 !important; grid-row: 5 !important; }
            .site-navbar.farmer-nav .nav-dashboard-link { grid-column: 1 !important; grid-row: 6 !important; }

            /* Right: exactly the same five levels as the left side. */
            .site-navbar.farmer-nav .nav-role-pill {
                grid-column: 2 !important;
                grid-row: 2 !important;
                justify-content: flex-start !important;
                align-items: center !important;
                width: 100% !important;
            }

            .site-navbar.farmer-nav .nav-notification-item {
                grid-column: 2 !important;
                grid-row: 3 !important;
                justify-content: flex-start !important;
                align-items: center !important;
                width: 100% !important;
            }

            .site-navbar.farmer-nav .navbar-nav > .nav-item:has(form[action*="logout"]) {
                grid-column: 2 !important;
                grid-row: 4 !important;
                justify-content: flex-start !important;
                align-items: center !important;
                width: 100% !important;
            }

            .site-navbar.farmer-nav .navbar-nav > .nav-item:has(#themeToggle) {
                grid-column: 2 !important;
                grid-row: 5 !important;
                justify-content: flex-start !important;
                align-items: center !important;
                width: 100% !important;
                margin: 0 !important;
            }

            /* Keep the actual controls aligned to the same left edge. */
            .site-navbar.farmer-nav .nav-role-pill span,
            .site-navbar.farmer-nav .nav-notification-link,
            .site-navbar.farmer-nav .navbar-nav > .nav-item:has(form[action*="logout"]) form,
            .site-navbar.farmer-nav .theme-toggle {
                margin-left: 0 !important;
                margin-right: 0 !important;
            }

            .site-navbar.farmer-nav .nav-role-pill span { min-height: 34px !important; }
            .site-navbar.farmer-nav .nav-notification-link { min-height: 38px !important; height: 38px !important; }
            .site-navbar.farmer-nav .navbar-nav > .nav-item:has(form[action*="logout"]) .btn { min-height: 38px !important; height: 38px !important; }
            .site-navbar.farmer-nav .theme-toggle { min-height: 38px !important; height: 38px !important; }
        }

        /* Final farmer mobile right-column alignment only. */
        @media (max-width: 991.98px) {
            .site-navbar.farmer-nav .nav-role-pill,
            .site-navbar.farmer-nav .nav-notification-item,
            .site-navbar.farmer-nav .navbar-nav > .nav-item:has(form[action="logout"]),
            .site-navbar.farmer-nav .navbar-nav > .nav-item:has(#themeToggle) {
                justify-content: flex-start !important;
                align-items: center !important;
                width: 100% !important;
                padding-left: 0 !important;
                margin-left: 0 !important;
            }

            .site-navbar.farmer-nav .nav-role-pill span,
            .site-navbar.farmer-nav .nav-notification-link,
            .site-navbar.farmer-nav .navbar-nav > .nav-item:has(form[action="logout"]) form,
            .site-navbar.farmer-nav .navbar-nav > .nav-item:has(form[action="logout"]) .btn,
            .site-navbar.farmer-nav .theme-toggle {
                margin-left: 0 !important;
                margin-right: 0 !important;
            }

            .site-navbar.farmer-nav .theme-toggle {
                width: 112px !important;
                min-width: 112px !important;
                justify-content: flex-start !important;
                padding-left: .8rem !important;
                padding-right: .8rem !important;
            }

            .site-navbar.farmer-nav .mobile-theme-label {
                display: inline !important;
            }
        }

    
        /* FINAL MOBILE NAV FIX
           Compact 3-column menu: main links on the left, account actions on the right.
           This intentionally overrides the older mobile-nav rules above. */
        @media (max-width: 991.98px) {
            .site-navbar .navbar-collapse {
                max-height: none !important;
                overflow: visible !important;
                padding: .55rem 0 .65rem !important;
            }

            .site-navbar .navbar-collapse.collapsing {
                overflow: hidden !important;
            }

            .site-navbar .navbar-nav,
            .site-navbar.customer-nav .navbar-nav,
            .site-navbar.farmer-nav .navbar-nav {
                display: grid !important;
                grid-template-columns: minmax(0, 1fr) minmax(0, 1fr) minmax(105px, .9fr) !important;
                grid-auto-flow: row !important;
                gap: .28rem .45rem !important;
                width: 100% !important;
                align-items: center !important;
            }

            .site-navbar .navbar-nav > .nav-item {
                grid-column: auto !important;
                grid-row: auto !important;
                margin: 0 !important;
                width: auto !important;
                min-width: 0 !important;
                justify-content: flex-start !important;
            }

            /* Search always gets the complete first row. */
            .site-navbar .navbar-nav > .nav-search-item {
                grid-column: 1 / -1 !important;
                grid-row: 1 !important;
                margin: 0 0 .15rem !important;
            }

            .site-navbar .nav-search {
                width: 100% !important;
                height: 38px !important;
                margin: 0 !important;
            }

            /* Main navigation occupies columns 1–2. */
            .site-navbar .navbar-nav > .nav-item:nth-child(2) {
                grid-column: 1 !important;
                grid-row: 2 !important;
            }
            .site-navbar .navbar-nav > .nav-item:nth-child(3) {
                grid-column: 2 !important;
                grid-row: 2 !important;
            }
            .site-navbar .navbar-nav > .nav-item:nth-child(4) {
                grid-column: 1 !important;
                grid-row: 3 !important;
            }
            .site-navbar .navbar-nav > .nav-item:nth-child(5) {
                grid-column: 2 !important;
                grid-row: 3 !important;
            }

            .site-navbar .navbar-nav > .nav-item:nth-child(2) .nav-link,
            .site-navbar .navbar-nav > .nav-item:nth-child(3) .nav-link,
            .site-navbar .navbar-nav > .nav-item:nth-child(4) .nav-link,
            .site-navbar .navbar-nav > .nav-item:nth-child(5) .nav-link,
            .site-navbar .nav-dashboard-link .nav-link {
                min-height: 34px !important;
                height: 34px !important;
                padding: .3rem .5rem !important;
                font-size: .82rem !important;
                line-height: 1 !important;
            }

            .site-navbar .nav-dashboard-link {
                grid-column: 1 / 3 !important;
                grid-row: 4 !important;
            }

            /* Account controls use the third column and stay compact. */
            .site-navbar .nav-role-pill {
                grid-column: 3 !important;
                grid-row: 2 !important;
                justify-content: flex-start !important;
            }

            .site-navbar .nav-notification-item {
                grid-column: 3 !important;
                grid-row: 3 !important;
                justify-content: flex-start !important;
            }

            .site-navbar .navbar-nav > .nav-item:has(form[action*="logout"]) {
                grid-column: 3 !important;
                grid-row: 4 !important;
            }

            .site-navbar .navbar-nav > .nav-item:has(#themeToggle) {
                grid-column: 3 !important;
                grid-row: 5 !important;
                margin: 0 !important;
            }

            .site-navbar .nav-role-pill span,
            .site-navbar .nav-notification-link,
            .site-navbar .navbar-nav > .nav-item:has(form[action*="logout"]) .btn,
            .site-navbar .theme-toggle {
                height: 34px !important;
                min-height: 34px !important;
                max-height: 34px !important;
                font-size: .74rem !important;
                padding: .25rem .55rem !important;
                margin: 0 !important;
                white-space: nowrap !important;
            }

            .site-navbar .nav-notification-link {
                display: inline-flex !important;
                align-items: center !important;
                width: auto !important;
            }

            .site-navbar .navbar-nav > .nav-item:has(form[action*="logout"]) form {
                width: auto !important;
                margin: 0 !important;
            }

            .site-navbar .theme-toggle {
                width: 100% !important;
                max-width: 110px !important;
                justify-content: center !important;
            }

            .site-navbar .mobile-theme-label {
                display: none !important;
            }

            .site-navbar .mobile-action-label {
                display: none !important;
            }

            /* Customer cart/favourite, when present, share the compact action area. */
            .site-navbar.customer-nav .navbar-nav > .nav-item:has(.mobile-action-link) {
                grid-column: 3 !important;
            }

            .site-navbar.customer-nav .navbar-nav > .nav-item:has(.mobile-action-link) .mobile-action-link {
                height: 34px !important;
                min-height: 34px !important;
                padding: 0 .5rem !important;
                font-size: .74rem !important;
            }

            /* Keep the mobile bottom navigation sticky even while the hamburger is open. */
            .mobile-bottom-nav {
                display: grid !important;
                position: fixed !important;
                left: 8px !important;
                right: 8px !important;
                bottom: max(8px, env(safe-area-inset-bottom)) !important;
                z-index: 1100 !important;
            }

            /* Restore the mobile search to the full navbar width. */
            .site-navbar .navbar-collapse {
                width: 100% !important;
                flex-basis: 100% !important;
            }

            .site-navbar .navbar-nav {
                width: 100% !important;
                min-width: 100% !important;
            }

            .site-navbar .navbar-nav > .nav-search-item {
                width: 100% !important;
                min-width: 100% !important;
                max-width: none !important;
            }

            .site-navbar .nav-search {
                display: flex !important;
                width: 100% !important;
                max-width: none !important;
                min-width: 0 !important;
            }

            /* Dark-mode control should be a small icon button, not a long pill. */
            .site-navbar .theme-toggle {
                width: 42px !important;
                min-width: 42px !important;
                max-width: 42px !important;
                height: 34px !important;
                min-height: 34px !important;
                max-height: 34px !important;
                padding: 0 !important;
                justify-content: center !important;
                border-radius: 999px !important;
            }

            .site-navbar .mobile-theme-label {
                display: none !important;
            }

            body:has(.site-navbar .navbar-collapse.show) #chatbase-bubble-button,
            body:has(.site-navbar .navbar-collapse.show) .assistant-fab {
                display: none !important;
            }
        }

        @media (max-width: 480px) {
            .site-navbar .navbar-collapse {
                padding-top: .4rem !important;
                padding-bottom: .45rem !important;
            }

            .site-navbar .navbar-nav,
            .site-navbar.customer-nav .navbar-nav,
            .site-navbar.farmer-nav .navbar-nav {
                grid-template-columns: minmax(0, 1fr) minmax(0, 1fr) minmax(96px, .85fr) !important;
                gap: .2rem .3rem !important;
            }

            .site-navbar .navbar-nav > .nav-item:nth-child(2) .nav-link,
            .site-navbar .navbar-nav > .nav-item:nth-child(3) .nav-link,
            .site-navbar .navbar-nav > .nav-item:nth-child(4) .nav-link,
            .site-navbar .navbar-nav > .nav-item:nth-child(5) .nav-link,
            .site-navbar .nav-dashboard-link .nav-link {
                font-size: .78rem !important;
                min-height: 32px !important;
                height: 32px !important;
            }

            .site-navbar .nav-role-pill span,
            .site-navbar .nav-notification-link,
            .site-navbar .navbar-nav > .nav-item:has(form[action*="logout"]) .btn {
                height: 32px !important;
                min-height: 32px !important;
                font-size: .68rem !important;
            }

            .site-navbar .theme-toggle {
                width: 38px !important;
                min-width: 38px !important;
                max-width: 38px !important;
                height: 32px !important;
                min-height: 32px !important;
                max-height: 32px !important;
                padding: 0 !important;
                font-size: .68rem !important;
            }
        }



        /* FINAL UNIFIED MOBILE NAVBAR — same structure for customer, farmer and admin. */
        @media (max-width: 991.98px) {
            .site-navbar .navbar-nav,
            .site-navbar.customer-nav .navbar-nav,
            .site-navbar.farmer-nav .navbar-nav {
                display: grid !important;
                grid-template-columns: minmax(0, 1fr) minmax(0, 1fr) !important;
                grid-auto-rows: 42px !important;
                column-gap: .8rem !important;
                row-gap: .25rem !important;
                align-items: center !important;
                margin: 0 !important;
                width: 100% !important;
            }

            .site-navbar .navbar-nav > .nav-search-item {
                grid-column: 1 / -1 !important;
                grid-row: 1 !important;
                width: 100% !important;
                margin: 0 !important;
            }

            .site-navbar.farmer-nav .navbar-nav > .nav-search-item {
                grid-column: 1 / -1 !important;
            }

            /* Left column: Explore, About, Markets, Contact, Dashboard */
            .site-navbar .navbar-nav > .nav-item:nth-child(2) {
                grid-column: 1 !important; grid-row: 2 !important;
                justify-content: flex-start !important;
            }
            .site-navbar .navbar-nav > .nav-item:nth-child(3) {
                grid-column: 1 !important; grid-row: 4 !important;
                justify-content: flex-start !important;
            }
            .site-navbar .navbar-nav > .nav-item:nth-child(4) {
                grid-column: 1 !important; grid-row: 3 !important;
                justify-content: flex-start !important;
            }
            .site-navbar .navbar-nav > .nav-item:nth-child(5) {
                grid-column: 1 !important; grid-row: 5 !important;
                justify-content: flex-start !important;
            }
            .site-navbar .nav-dashboard-link {
                grid-column: 1 !important; grid-row: 6 !important;
                justify-content: flex-start !important;
            }

            /* Customer-only cart/favourite are removed so customer matches the shared layout. */
            .site-navbar.customer-nav .navbar-nav > .nav-item:has(.mobile-action-link) {
                display: none !important;
            }

            /* Right column: Role, Notification, Sign out, Dark mode */
            .site-navbar .nav-role-pill {
                grid-column: 2 !important; grid-row: 2 !important;
                justify-content: flex-start !important;
                width: 100% !important;
            }
            .site-navbar .nav-notification-item {
                grid-column: 2 !important; grid-row: 3 !important;
                justify-content: flex-start !important;
                width: 100% !important;
            }
            .site-navbar .navbar-nav > .nav-item:has(form[action*="logout"]) {
                grid-column: 2 !important; grid-row: 4 !important;
                justify-content: flex-start !important;
                width: 100% !important;
            }
            .site-navbar .navbar-nav > .nav-item:has(#themeToggle),
            .site-navbar .customer-theme-gap {
                grid-column: 2 !important; grid-row: 5 !important;
                justify-content: flex-start !important;
                width: 100% !important;
                margin: 0 !important;
            }

            .site-navbar .navbar-nav > .nav-item:nth-child(2) .nav-link,
            .site-navbar .navbar-nav > .nav-item:nth-child(3) .nav-link,
            .site-navbar .navbar-nav > .nav-item:nth-child(4) .nav-link,
            .site-navbar .navbar-nav > .nav-item:nth-child(5) .nav-link,
            .site-navbar .nav-dashboard-link .nav-link {
                justify-content: flex-start !important;
                text-align: left !important;
                padding-left: .55rem !important;
                width: 100% !important;
            }

            .site-navbar .nav-role-pill span {
                margin: 0 !important;
                min-height: 34px !important;
                padding: .35rem .7rem !important;
            }

            .site-navbar .nav-notification-link {
                width: auto !important;
                min-width: 0 !important;
                height: 38px !important;
                min-height: 38px !important;
                margin: 0 !important;
                padding: 0 .7rem !important;
                display: inline-flex !important;
                justify-content: flex-start !important;
                white-space: nowrap !important;
            }

            .site-navbar .navbar-nav > .nav-item:has(form[action*="logout"]) form {
                width: auto !important;
                margin: 0 !important;
            }

            .site-navbar .navbar-nav > .nav-item:has(form[action*="logout"]) .btn {
                height: 38px !important;
                min-height: 38px !important;
                padding: 0 .8rem !important;
                white-space: nowrap !important;
            }

            .site-navbar .theme-toggle {
                width: 38px !important;
                min-width: 38px !important;
                height: 38px !important;
                min-height: 38px !important;
                padding: 0 !important;
                margin: 0 !important;
            }
        }

        @media (max-width: 480px) {
            .site-navbar .navbar-nav {
                column-gap: .55rem !important;
                grid-auto-rows: 40px !important;
            }

            .site-navbar .nav-notification-link,
            .site-navbar .navbar-nav > .nav-item:has(form[action*="logout"]) .btn {
                font-size: .76rem !important;
            }
        }

</style>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark sticky-top site-navbar @auth @if(auth()->user()->role === 'customer') customer-nav @endif @if(auth()->user()->role === 'farmer') farmer-nav @endif @endauth">
    <div class="container">

        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}">
            <span class="brand-mark"><i class="bi bi-basket2-fill"></i></span>
            <span>Market<span>Link</span></span>
        </a>

        <div class="navbar-actions">
            <button id="themeToggle" type="button" class="theme-toggle" aria-label="Switch color theme" aria-pressed="false">
                <i class="bi bi-moon-stars"></i>
            </button>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>

        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
                <li class="nav-item nav-search-item">
                    <form class="nav-search" action="{{ route('products.index') }}" method="GET">
                        <i class="bi bi-search" aria-hidden="true"></i>
                        <input name="q" value="{{ request('q') }}" placeholder="Search products, farmers, or markets..." aria-label="Search products, farmers, or markets">
                        <button type="submit" aria-label="Search"><i class="bi bi-arrow-up-right"></i></button>
                    </form>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('products.index','products.show','products.compare') ? 'active' : '' }}" href="{{ route('products.index') }}"><i class="bi bi-compass me-1"></i>Explore</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('markets.*') ? 'active' : '' }}" href="{{ route('markets.index') }}"><i class="bi bi-shop me-1"></i>Markets</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}"><i class="bi bi-info-circle me-1"></i>About</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}"><i class="bi bi-chat-dots me-1"></i>Contact</a>
                </li>

                @auth
                    @php
                        $unreadCount = \App\Models\UserNotification::where('user_id', auth()->id())->whereNull('read_at')->count();
                        $cartCount = auth()->user()->role === 'customer'
                            ? \App\Models\CartItem::where('user_id', auth()->id())->sum('quantity')
                            : 0;
                    @endphp

                    @if(auth()->user()->role === 'customer')
                        <li class="nav-item">
                            <a class="nav-icon-link mobile-action-link" href="{{ route('cart.index') }}" aria-label="Cart" title="Cart" data-cart-count="{{ $cartCount }}">
                                <i class="bi bi-bag"></i>
                                <span class="mobile-action-label">Add to cart</span>
                                @if($cartCount > 0)<span class="nav-badge cart-count-badge">{{ $cartCount > 99 ? '99+' : $cartCount }}</span>@endif
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-icon-link mobile-action-link" href="{{ route('customer.favorites') }}" aria-label="Favorites" title="Favorites">
                                <i class="bi bi-heart"></i>
                                <span class="mobile-action-label">Favourite</span>
                            </a>
                        </li>
                    @endif

                    <li class="nav-item nav-notification-item">
                        <a class="nav-icon-link nav-notification-link" href="{{ route('notifications.index') }}" aria-label="Notifications" title="Notifications">
                            <i class="bi bi-bell"></i>
                            <span class="mobile-notification-label">Notification</span>
                            @if($unreadCount > 0)<span class="nav-badge">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>@endif
                        </a>
                    </li>

                    <li class="nav-item nav-dashboard-link">
                        <a class="nav-link" href="{{ route('dashboard') }}"><i class="bi bi-grid-1x2 me-1"></i>Dashboard</a>
                    </li>

                    <li class="nav-item nav-role-pill">
                        <span>{{ ucfirst(auth()->user()->role) }}</span>
                    </li>

                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="btn btn-sm btn-outline-light rounded-pill px-3" type="submit"><i class="bi bi-box-arrow-right me-1"></i>Sign out</button>
                        </form>
                    </li>
                @else
                    <li class="nav-item"><a class="btn btn-sm btn-light rounded-pill px-3" href="{{ route('login') }}"><i class="bi bi-box-arrow-in-right me-1"></i>Sign in</a></li>
                    <li class="nav-item"><a class="btn btn-sm btn-warning rounded-pill px-3" href="{{ route('register') }}"><i class="bi bi-person-plus me-1"></i>Join MarketLink</a></li>
                @endauth

            </ul>
        </div>
    </div>
</nav>

@if(session('success'))
    <div class="container alert-wrap">
        <div class="alert alert-success alert-dismissible fade show rounded-4" role="alert">
            <i class="bi bi-check-circle me-1"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
@endif

@if($errors->any())
    <div class="container alert-wrap">
        <div class="alert alert-danger rounded-4" role="alert">
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </div>
    </div>
@endif

<main class="site-main">
    @yield('content')
</main>

<footer class="site-footer">
    <div class="footer-orb footer-orb-one"></div>
    <div class="footer-orb footer-orb-two"></div>

    <div class="container position-relative">
        <div class="footer-grid">
            <div class="footer-brand">
                <a href="{{ route('home') }}" class="footer-logo">
                    <span class="footer-logo-mark"><i class="bi bi-basket2-fill"></i></span>
                    <span>Market<span>Link</span></span>
                </a>
                <p class="footer-copy">
                    A modern local-market platform connecting customers with farmers,
                    fresh weekly stock and convenient pickup pre-orders.
                </p>
                <div class="footer-socials">
                    <a href="mailto:hello@marketlink.local" aria-label="Email"><i class="bi bi-envelope"></i></a>
                    <a href="{{ route('contact') }}" aria-label="Contact"><i class="bi bi-chat-dots"></i></a>
                    <a href="{{ route('markets.index') }}" aria-label="Markets"><i class="bi bi-shop"></i></a>
                </div>
            </div>

            <div class="footer-links">
                <h6>Platform</h6>
                <a href="{{ route('products.index') }}">Products</a>
                <a href="{{ route('markets.index') }}"><i class="bi bi-shop me-1"></i>Markets</a>
                <a href="{{ route('about') }}"><i class="bi bi-info-circle me-1"></i>About</a>
                <a href="{{ route('contact') }}"><i class="bi bi-chat-dots me-1"></i>Contact</a>
            </div>

            <div class="footer-links">
                <h6>For farmers</h6>
                <a href="{{ route('register') }}">Create a stall</a>
                <a href="{{ route('login') }}">Farmer login</a>
                <a href="{{ route('about') }}">How it works</a>
            </div>

            <div class="footer-pickup">
                <span class="pickup-label"><i class="bi bi-check2-circle"></i>Pickup first</span>
                <h6>Reserve now. Pay at pickup.</h6>
                <p>Choose your products, reserve a pickup slot, then pay the farmer in person at the market.</p>
                <a href="{{ route('products.index') }}" class="footer-action">Browse local stock <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>

        <div class="footer-bottom">
            <div>© {{ date('Y') }} MarketLink <span>·</span> eGreen Basket</div>
            <div class="footer-location"><i class="bi bi-geo-alt"></i>Hyderabad, Sindh</div>
        </div>
    </div>
</footer>



@auth
<div class="mobile-bottom-nav">
    <a href="{{ route('home') }}"><i class="bi bi-house"></i><span>Home</span></a>
    <a href="{{ route('products.index') }}"><i class="bi bi-search"></i><span>Explore</span></a>
    @if(auth()->user()->role === 'customer')
        <a href="{{ route('cart.index') }}"><i class="bi bi-bag"></i><span>Cart</span></a>
        <a href="{{ route('customer.favorites') }}"><i class="bi bi-heart"></i><span>Saved</span></a>
    @elseif(auth()->user()->role === 'farmer')
        <a href="{{ route('farmer.orders') }}"><i class="bi bi-receipt"></i><span>Orders</span></a>
        <a href="{{ route('farmer.products') }}"><i class="bi bi-box-seam"></i><span>Stock</span></a>
    @else
        <a href="{{ route('admin.reports') }}"><i class="bi bi-graph-up"></i><span>Reports</span></a>
        <a href="{{ route('admin.users') }}"><i class="bi bi-people"></i><span>Users</span></a>
    @endif
    <a href="{{ route('dashboard') }}"><i class="bi bi-grid"></i><span>Dashboard</span></a>
</div>
@endauth

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="{{ asset('js/marketlink.js') }}"></script>
@stack('scripts')
@auth
<script>
(function(){if(!window.chatbase||window.chatbase("getState")!=="initialized"){window.chatbase=(...arguments)=>{if(!window.chatbase.q){window.chatbase.q=[]}window.chatbase.q.push(arguments)};window.chatbase=new Proxy(window.chatbase,{get(target,prop){if(prop==="q"){return target.q}return(...args)=>target(prop,...args)}})}const onLoad=function(){const script=document.createElement("script");script.src="https://www.chatbase.co/embed.min.js";script.id="WL7Sfr56LADEqAkdR2tXW";script.domain="www.chatbase.co";document.body.appendChild(script)};if(document.readyState==="complete"){onLoad()}else{window.addEventListener("load",onLoad)}})();
</script>
@endauth

</body>
</html>
