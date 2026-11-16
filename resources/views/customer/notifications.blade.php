@extends('layouts.app')
@section('content')

<style>
/* Customer Notifications page only. Existing routes/actions/data are preserved. */
.customer-notifications-page{
    padding:42px 0 96px;
}
.customer-notifications-page .notifications-hero{
    display:flex;
    align-items:flex-end;
    justify-content:space-between;
    gap:22px;
    margin-bottom:20px;
    padding:28px 30px;
    border:1px solid var(--line);
    border-radius:24px;
    background:linear-gradient(135deg,#f3faf7 0%,#ffffff 68%,#fff8e8 100%);
    box-shadow:var(--shadow);
}
.customer-notifications-page .notifications-hero h1{
    margin:6px 0 4px;
    font-size:clamp(2rem,4vw,3rem);
}
.customer-notifications-page .notifications-hero p{
    margin:0;
    color:var(--muted);
    font-size:.82rem;
}
.customer-notifications-page .notifications-panel{
    padding:8px 18px;
}
.customer-notifications-page .notice-row{
    display:flex;
    align-items:flex-start;
    gap:14px;
    padding:18px 4px;
    border-bottom:1px solid var(--line);
}
.customer-notifications-page .notice-row:last-child{
    border-bottom:0;
}
.customer-notifications-page .notice-icon{
    width:42px;
    height:42px;
    flex:0 0 42px;
    display:grid;
    place-items:center;
    border-radius:14px;
    background:var(--soft);
    color:var(--green);
    font-size:1rem;
}
.customer-notifications-page .notice-content{
    min-width:0;
    flex:1;
}
.customer-notifications-page .notice-top{
    display:flex;
    align-items:flex-start;
    justify-content:space-between;
    gap:16px;
}
.customer-notifications-page .notice-title{
    margin:0;
    color:var(--ink);
    font-size:.9rem;
    font-weight:800;
    line-height:1.35;
}
.customer-notifications-page .notice-message{
    margin:5px 0 4px;
    color:var(--muted);
    font-size:.74rem;
    line-height:1.55;
}
.customer-notifications-page .notice-time{
    color:var(--muted);
    font-size:.63rem;
}
.customer-notifications-page .notice-row.unread{
    background:linear-gradient(90deg,rgba(11,128,109,.035),transparent 72%);
}
.customer-notifications-page .notice-row.unread .notice-icon{
    background:#e7f7f0;
    color:#087e6e;
}
.customer-notifications-page .notice-row.unread .notice-title:after{
    content:"";
    display:inline-block;
    width:6px;
    height:6px;
    margin-left:7px;
    margin-bottom:2px;
    border-radius:50%;
    background:#f4b000;
}
.customer-notifications-page .notice-row.read{
    opacity:.82;
}
.customer-notifications-page .notice-action{
    flex:0 0 auto;
}
.customer-notifications-page .notice-action .btn{
    font-size:.66rem;
    padding:6px 11px;
}
.customer-notifications-page .notification-empty{
    padding:62px 20px;
    text-align:center;
}
.customer-notifications-page .notification-empty-icon{
    width:56px;
    height:56px;
    margin:0 auto 12px;
    display:grid;
    place-items:center;
    border-radius:18px;
    background:var(--surface-2);
    color:var(--green);
    font-size:1.35rem;
}
.customer-notifications-page .notification-empty strong{
    display:block;
    color:var(--ink);
    font-size:.9rem;
}
.customer-notifications-page .notification-empty span{
    display:block;
    margin-top:4px;
    color:var(--muted);
    font-size:.7rem;
}

.customer-notifications-page .notification-pagination-wrap{
    display:flex;
    justify-content:center;
    margin-top:18px;
}
.customer-notifications-page .notification-pagination{
    display:flex;
    align-items:center;
    justify-content:center;
    gap:6px;
    flex-wrap:wrap;
}
.customer-notifications-page .notification-page-link{
    min-width:36px;
    height:36px;
    padding:0 11px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    border:1px solid var(--line);
    border-radius:11px;
    background:var(--surface);
    color:var(--ink);
    font-size:.67rem;
    font-weight:800;
    text-decoration:none;
}
.customer-notifications-page .notification-page-link:hover{
    background:var(--surface-2);
    border-color:var(--green);
    color:var(--green);
}
.customer-notifications-page .notification-page-link.active{
    background:var(--green);
    border-color:var(--green);
    color:#fff;
}
.customer-notifications-page .notification-page-link.disabled{
    opacity:.45;
    pointer-events:none;
}
.customer-notifications-page .notification-page-link.dots{
    border-color:transparent;
    background:transparent;
    pointer-events:none;
}

html.theme-dark .customer-notifications-page .notifications-hero{
    background:linear-gradient(135deg,#0c2a24 0%,#0d211c 68%,#29271b 100%);
    border-color:var(--line);
}
html.theme-dark .customer-notifications-page .notifications-panel{
    background:var(--surface);
}
html.theme-dark .customer-notifications-page .notice-row.unread{
    background:linear-gradient(90deg,rgba(79,195,157,.07),transparent 72%);
}
html.theme-dark .customer-notifications-page .notice-icon{
    background:#15372f;
    color:#74d4ba;
}
html.theme-dark .customer-notifications-page .notice-row.unread .notice-icon{
    background:#153c33;
    color:#7bdcc1;
}
html.theme-dark .customer-notifications-page .notification-empty-icon{
    background:var(--surface-2);
}

@media(max-width:767.98px){
    .customer-notifications-page{
        padding:30px 0 105px;
    }
    .customer-notifications-page .notifications-hero{
        align-items:flex-start;
        flex-direction:column;
        padding:22px;
        border-radius:20px;
    }
    .customer-notifications-page .notifications-panel{
        padding:6px 13px;
        border-radius:20px;
    }
    .customer-notifications-page .notice-row{
        gap:10px;
        padding:15px 2px;
    }
    .customer-notifications-page .notice-icon{
        width:38px;
        height:38px;
        flex-basis:38px;
        border-radius:12px;
    }
    .customer-notifications-page .notice-top{
        flex-direction:column;
        gap:9px;
    }
    .customer-notifications-page .notice-action{
        align-self:flex-start;
    }
}
</style>

<div class="customer-notifications-page">
    <div class="container">
        <section class="notifications-hero">
            <div>
                <span class="eyebrow">Inbox</span>
                <h1>Notifications</h1>
                <p>Order updates, reviews and MarketLink activity.</p>
            </div>
            <form method="POST" action="{{ route('notifications.read_all') }}">
                @csrf
                <button class="btn btn-outline-dark rounded-pill" type="submit">
                    <i class="bi bi-check2-all me-1"></i>Mark all as read
                </button>
            </form>
        </section>

        <section class="panel notifications-panel">
            @forelse($notifications as $n)
                @php
                    $icon = $n->type === 'review'
                        ? 'bi-star-fill'
                        : ($n->type === 'order' ? 'bi-bag-check-fill' : 'bi-bell-fill');
                @endphp

                <article class="notice-row {{ $n->read_at ? 'read' : 'unread' }}">
                    <span class="notice-icon" aria-hidden="true">
                        <i class="bi {{ $icon }}"></i>
                    </span>

                    <div class="notice-content">
                        <div class="notice-top">
                            <div>
                                <p class="notice-title">{{ $n->title }}</p>
                                <p class="notice-message">{{ $n->message }}</p>
                                <small class="notice-time">{{ $n->created_at->diffForHumans() }}</small>
                            </div>

                            @if(!$n->read_at)
                                <div class="notice-action">
                                    <form method="POST" action="{{ route('notifications.read',$n) }}">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-success rounded-pill" type="submit">
                                            <i class="bi bi-check2 me-1"></i>Mark read
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </article>
            @empty
                <div class="notification-empty">
                    <div class="notification-empty-icon">
                        <i class="bi bi-bell-slash"></i>
                    </div>
                    <strong>You're all caught up.</strong>
                    <span>No new notifications right now.</span>
                </div>
            @endforelse
        </section>

        @if($notifications->hasPages())
            @php
                $currentPage = $notifications->currentPage();
                $lastPage = $notifications->lastPage();
                $pageWindowStart = max(1, $currentPage - 2);
                $pageWindowEnd = min($lastPage, $currentPage + 2);
            @endphp

            <div class="notification-pagination-wrap">
                <nav class="notification-pagination" aria-label="Notifications pages">
                    @if($notifications->onFirstPage())
                        <span class="notification-page-link disabled"><i class="bi bi-chevron-left"></i></span>
                    @else
                        <a class="notification-page-link" href="{{ $notifications->previousPageUrl() }}" aria-label="Previous page">
                            <i class="bi bi-chevron-left"></i>
                        </a>
                    @endif

                    @if($pageWindowStart > 1)
                        <a class="notification-page-link" href="{{ $notifications->url(1) }}">1</a>
                        @if($pageWindowStart > 2)
                            <span class="notification-page-link dots">…</span>
                        @endif
                    @endif

                    @for($page = $pageWindowStart; $page <= $pageWindowEnd; $page++)
                        @if($page === $currentPage)
                            <span class="notification-page-link active" aria-current="page">{{ $page }}</span>
                        @else
                            <a class="notification-page-link" href="{{ $notifications->url($page) }}">{{ $page }}</a>
                        @endif
                    @endfor

                    @if($pageWindowEnd < $lastPage)
                        @if($pageWindowEnd < $lastPage - 1)
                            <span class="notification-page-link dots">…</span>
                        @endif
                        <a class="notification-page-link" href="{{ $notifications->url($lastPage) }}">{{ $lastPage }}</a>
                    @endif

                    @if($notifications->hasMorePages())
                        <a class="notification-page-link" href="{{ $notifications->nextPageUrl() }}" aria-label="Next page">
                            <i class="bi bi-chevron-right"></i>
                        </a>
                    @else
                        <span class="notification-page-link disabled"><i class="bi bi-chevron-right"></i></span>
                    @endif
                </nav>
            </div>
        @endif
    </div>
</div>

@endsection
