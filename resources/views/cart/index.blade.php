@extends('layouts.app')

@section('content')

<div class="dashboard-wrap">

    <div class="container">

        <div class="dashboard-hero mb-4">

            <div>
                <span class="eyebrow">Shopping bag</span>
                <h1>Your market cart</h1>
                <p>
                    Add several products, adjust quantities and check out
                    with pickup details.
                </p>
            </div>

            <a
                href="{{ route('products.index') }}"
                class="btn btn-outline-dark rounded-pill"
            >
                <i class="bi bi-arrow-left me-1"></i>
                Continue shopping
            </a>

        </div>


        @if($items->isEmpty())

            <div class="favorites-empty">

                <div class="favorites-empty-icon">
                    <i class="bi bi-bag"></i>
                </div>

                <h3>Your cart is empty</h3>

                <p>
                    Explore local products and add something fresh.
                </p>

                <a
                    href="{{ route('products.index') }}"
                    class="btn btn-success rounded-pill px-4"
                >
                    Browse products
                </a>

            </div>

        @else

            <div class="row g-4">

                <div class="col-xl-8">

                    <div class="panel">

                        <div class="cart-heading">
                            <div>
                                <span class="eyebrow">Saved items</span>
                                <h4 class="mb-0">
                                    {{ $cartCount }}
                                    {{ $cartCount === 1 ? 'item' : 'items' }}
                                </h4>
                            </div>
                        </div>


                        @foreach($items as $item)

                            <div class="cart-row">

                                <div class="cart-art"><x-product-media :product="$item->product" /></div>


                                <div class="flex-grow-1">

                                    <h5 class="mb-1">
                                        {{ $item->product->name }}
                                    </h5>

                                    <small class="text-muted">
                                        {{
                                            $item->product->farmer
                                                ->farmerProfile
                                                ?->stall_name
                                            ?? $item->product->farmer->name
                                        }}
                                    </small>

                                    <div class="mt-1 text-success fw-bold">
                                        Rs {{
                                            number_format(
                                                $item->product->price,
                                                2
                                            )
                                        }}
                                        /
                                        {{ $item->product->unit }}
                                    </div>

                                    @if($item->product->stock_quantity <= 5)
                                        <span class="badge bg-warning-subtle text-warning-emphasis mt-2">
                                            Only {{ $item->product->stock_quantity }}
                                            {{ $item->product->unit }} left
                                        </span>
                                    @endif

                                </div>


                                <form
                                    method="POST"
                                    action="{{ route('cart.update', $item->product) }}"
                                    class="cart-quantity-form"
                                >

                                    @csrf
                                    @method('PATCH')

                                    <label
                                        class="visually-hidden"
                                        for="qty_{{ $item->id }}"
                                    >
                                        Quantity
                                    </label>

                                    <input
                                        id="qty_{{ $item->id }}"
                                        type="number"
                                        name="quantity"
                                        min="0"
                                        max="{{ $item->product->stock_quantity }}"
                                        value="{{ $item->quantity }}"
                                        class="form-control"
                                    >

                                    <button
                                        class="btn btn-outline-dark btn-sm rounded-pill"
                                        type="submit"
                                    >
                                        Update
                                    </button>

                                </form>


                                <strong class="text-nowrap">
                                    Rs {{
                                        number_format(
                                            $item->product->price * $item->quantity
                                        )
                                    }}
                                </strong>


                                <form
                                    method="POST"
                                    action="{{ route('cart.remove', $item->product) }}"
                                >

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn btn-outline-danger btn-sm rounded-circle"
                                        title="Remove"
                                        aria-label="Remove {{ $item->product->name }}"
                                    >
                                        <i class="bi bi-trash"></i>
                                    </button>

                                </form>

                            </div>

                        @endforeach

                    </div>

                </div>


                <div class="col-xl-4">

                    <div
                        class="checkout-card sticky-xl-top"
                        style="top:90px"
                    >

                        <span class="eyebrow">
                            Summary
                        </span>

                        <h4 class="mt-2">
                            Cart total
                        </h4>


                        <div class="d-flex justify-content-between my-3">
                            <span>Items</span>
                            <strong>{{ $cartCount }}</strong>
                        </div>


                        <div class="d-flex justify-content-between pb-3 border-bottom">
                            <span>Subtotal</span>

                            <strong>
                                Rs {{ number_format($total) }}
                            </strong>
                        </div>


                        <div class="pay-note mt-3">

                            <i class="bi bi-wallet2"></i>

                            <div>
                                <strong>Pay at pickup</strong>

                                <small>
                                    No online payment is required.
                                </small>
                            </div>

                        </div>


                        <a
                            href="{{ route('checkout') }}"
                            class="btn btn-success w-100 rounded-pill mt-4 py-3"
                        >
                            Continue to checkout
                            <i class="bi bi-arrow-right ms-1"></i>
                        </a>


                        <form
                            method="POST"
                            action="{{ route('cart.clear') }}"
                            class="mt-2"
                            onsubmit="return confirm('Clear all items from your cart?');"
                        >

                            @csrf
                            @method('DELETE')

                            <button
                                class="btn btn-outline-secondary w-100 rounded-pill"
                                type="submit"
                            >
                                Clear cart
                            </button>

                        </form>

                    </div>

                </div>

            </div>

        @endif

    </div>

</div>


<style>
    .cart-heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 7px;
    }

    .cart-quantity-form {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .cart-quantity-form input {
        width: 78px;
    }

    @media (max-width: 767px) {
        .cart-quantity-form {
            width: 100%;
            justify-content: flex-start;
        }

        .cart-quantity-form input {
            width: 90px;
        }
    }
</style>

@endsection
