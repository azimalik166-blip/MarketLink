<?php

namespace App\Http\Controllers;

use App\Models\{CartItem, Product, Order, OrderItem, PickupSlot, UserNotification};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CartController extends Controller
{
    private function ensureCustomer(): void
    {
        abort_unless(
            auth()->check() && auth()->user()->role === 'customer',
            403
        );
    }

    private function importLegacySessionCart(): void
    {
        $legacy = session('marketlink_cart', []);

        if (!$legacy) {
            return;
        }

        DB::transaction(function () use ($legacy) {
            foreach ($legacy as $productId => $quantity) {
                $product = Product::find($productId);

                if (!$product || !$product->is_available || $product->stock_quantity < 1) {
                    continue;
                }

                $qty = min(
                    max(1, (int) $quantity),
                    (int) $product->stock_quantity
                );

                $item = CartItem::firstOrNew([
                    'user_id' => auth()->id(),
                    'product_id' => $product->id,
                ]);

                $item->quantity = min(
                    max(1, (int) $item->quantity + $qty),
                    (int) $product->stock_quantity
                );

                $item->save();
            }
        });

        session()->forget('marketlink_cart');
    }

    private function items()
    {
        $this->importLegacySessionCart();

        $items = CartItem::with([
                'product.category',
                'product.farmer.farmerProfile',
                'product.market',
            ])
            ->where('user_id', auth()->id())
            ->latest()
            ->get()
            ->filter(function (CartItem $item) {
                return $item->product
                    && $item->product->is_available
                    && $item->product->stock_quantity > 0;
            });

        // Keep quantities valid against live stock.
        foreach ($items as $item) {
            $max = (int) $item->product->stock_quantity;

            if ($item->quantity > $max) {
                $item->quantity = $max;
                $item->save();
            }
        }

        return $items->filter(
            fn (CartItem $item) => $item->quantity > 0
        )->values();
    }

    private function ensureDefaultSlots($farmer, $market): void
    {
        $query = PickupSlot::where('farmer_id', $farmer->id)
            ->whereDate('slot_date', '>=', today())
            ->whereDate('slot_date', '<=', today()->addDays(14))
            ->where('is_active', true);

        if ($market) {
            $query->where('market_id', $market->id);
        } else {
            $query->whereNull('market_id');
        }

        if ($query->exists()) {
            return;
        }

        /*
         * Demo-safe fallback: if a farmer has not configured any
         * slots yet, create simple pickup windows so checkout is
         * immediately usable. Farmers can later replace/remove them.
         */
        $windows = [
            ['09:00:00', '10:00:00'],
            ['10:00:00', '11:00:00'],
            ['11:00:00', '12:00:00'],
        ];

        for ($day = 0; $day <= 14; $day++) {
            $date = today()->addDays($day);

            foreach ($windows as [$start, $end]) {
                $attributes = [
                    'farmer_id' => $farmer->id,
                    'market_id' => $market?->id,
                    'slot_date' => $date->toDateString(),
                    'start_time' => $start,
                    'end_time' => $end,
                    'capacity' => 10,
                    'is_active' => true,
                ];

                PickupSlot::firstOrCreate([
                    'farmer_id' => $attributes['farmer_id'],
                    'market_id' => $attributes['market_id'],
                    'slot_date' => $attributes['slot_date'],
                    'start_time' => $attributes['start_time'],
                    'end_time' => $attributes['end_time'],
                ], $attributes);
            }
        }
    }

    private function slotsFor($farmer, $market)
    {
        $this->ensureDefaultSlots($farmer, $market);

        $query = PickupSlot::where('farmer_id', $farmer->id);

        if ($market) {
            $query->where('market_id', $market->id);
        } else {
            $query->whereNull('market_id');
        }

        return $query
            ->whereDate('slot_date', '>=', today())
            ->whereDate('slot_date', '<=', today()->addDays(14))
            ->where('is_active', true)
            ->orderBy('slot_date')
            ->orderBy('start_time')
            ->get();
    }

    public function index()
    {
        $this->ensureCustomer();

        $items = $this->items();

        $total = $items->sum(
            fn (CartItem $item) =>
                (float) $item->product->price * $item->quantity
        );

        $cartCount = $items->sum('quantity');

        return view(
            'cart.index',
            compact('items', 'total', 'cartCount')
        );
    }

    public function add(Request $request)
    {
        $this->ensureCustomer();

        $data = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1', 'max:999'],
        ]);

        $product = Product::findOrFail($data['product_id']);

        abort_if(
            !$product->is_available ||
            $product->stock_quantity < $data['quantity'],
            422,
            'That quantity is no longer available.'
        );

        $item = CartItem::firstOrNew([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
        ]);

        $item->quantity = min(
            max(1, (int) $item->quantity + (int) $data['quantity']),
            (int) $product->stock_quantity
        );

        $item->save();

        
        $message = $product->name . ' added to your cart.';

        if ($request->expectsJson()) {
            $cartCount = CartItem::where('user_id', auth()->id())->sum('quantity');

            return response()->json([
                'message' => $message,
                'cart_count' => (int) $cartCount,
            ]);
        }

        return back()->with('success', $message);
    }

    public function update(Request $request, Product $product)
    {
        $this->ensureCustomer();

        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:0', 'max:999'],
        ]);

        $item = CartItem::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->first();

        if (!$item) {
            return back()->with('error', 'That product is not in your cart.');
        }

        if ((int) $data['quantity'] === 0) {
            $item->delete();

            return back()->with('success', 'Item removed from your cart.');
        }

        abort_if(
            !$product->is_available ||
            $product->stock_quantity < $data['quantity'],
            422,
            'Only ' . $product->stock_quantity . ' ' . $product->unit . ' is currently available.'
        );

        $item->update([
            'quantity' => (int) $data['quantity'],
        ]);

        return back()->with('success', 'Cart updated.');
    }

    public function remove(Product $product)
    {
        $this->ensureCustomer();

        CartItem::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->delete();

        return back()->with('success', 'Item removed from your cart.');
    }

    public function clear()
    {
        $this->ensureCustomer();

        CartItem::where('user_id', auth()->id())->delete();

        session()->forget('marketlink_cart');

        return back()->with('success', 'Cart cleared.');
    }

    public function checkout()
    {
        $this->ensureCustomer();

        $items = $this->items();

        abort_if($items->isEmpty(), 422, 'Your cart is empty.');

        $groups = $items->groupBy(
            fn (CartItem $item) =>
                $item->product->farmer_id . ':' .
                ($item->product->market_id ?? 0)
        );

        $groupData = [];

        foreach ($groups as $key => $group) {
            $first = $group->first()->product;

            $groupData[$key] = [
                'key' => $key,
                'farmer' => $first->farmer,
                'market' => $first->market,
                'items' => $group,
                'total' => $group->sum(
                    fn (CartItem $item) =>
                        (float) $item->product->price * $item->quantity
                ),
            ];
        }

        return view('cart.checkout', [
            'groups' => collect($groupData),
            'grandTotal' => $items->sum(
                fn (CartItem $item) =>
                    (float) $item->product->price * $item->quantity
            ),
        ]);
    }

    public function store(Request $request)
    {
        $this->ensureCustomer();

        $items = $this->items();

        abort_if($items->isEmpty(), 422, 'Your cart is empty.');

        $groups = $items->groupBy(
            fn (CartItem $item) =>
                $item->product->farmer_id . ':' .
                ($item->product->market_id ?? 0)
        );

        $postedGroups = $request->input('groups', []);
        $created = [];

        DB::transaction(function () use ($groups, $postedGroups, &$created) {
            foreach ($groups as $groupKey => $group) {
                $data = $postedGroups[$groupKey] ?? null;

                abort_unless(
                    is_array($data),
                    422,
                    'Please choose pickup date and time for every farmer.'
                );

                $pickupDate = $data['pickup_date'] ?? null;
                $pickupTime = $data['pickup_time'] ?? null;

                abort_unless(
                    is_string($pickupDate) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $pickupDate),
                    422,
                    'Choose a valid pickup date.'
                );

                abort_unless(
                    is_string($pickupTime) && preg_match('/^([01]\d|2[0-3]):[0-5]\d$/', $pickupTime),
                    422,
                    'Choose a valid pickup time.'
                );

                $validatedDate = Carbon::createFromFormat('Y-m-d', $pickupDate)->startOfDay();

                abort_if(
                    $validatedDate->lt(today()),
                    422,
                    'Pickup date cannot be in the past.'
                );

                $first = $group->first()->product;

                $orderTotal = 0;

                foreach ($group as $cartItem) {
                    $product = Product::lockForUpdate()->findOrFail($cartItem->product_id);
                    $qty = (int) $cartItem->quantity;

                    abort_if(
                        !$product->is_available || $product->stock_quantity < $qty,
                        422,
                        'Stock changed for ' . $product->name . '. Please review your cart.'
                    );

                    $orderTotal += (float) $product->price * $qty;
                }

                $displayTime = Carbon::createFromFormat('H:i', $pickupTime)->format('h:i A');

                $order = Order::create([
                    'order_number' =>
                        'ML-' . now()->format('ymdHis') . '-' . Str::upper(Str::random(4)),
                    'customer_id' => auth()->id(),
                    'farmer_id' => $first->farmer_id,
                    'market_id' => $first->market_id,
                    'pickup_date' => $validatedDate->toDateString(),
                    'pickup_slot' => $displayTime,
                    'status' => 'placed',
                    'total_amount' => $orderTotal,
                    'notes' => $data['notes'] ?? null,
                    'placed_at' => now(),
                ]);

                foreach ($group as $cartItem) {
                    $product = Product::lockForUpdate()->findOrFail($cartItem->product_id);
                    $qty = (int) $cartItem->quantity;
                    $lineTotal = (float) $product->price * $qty;

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $qty,
                        'unit_price' => $product->price,
                        'line_total' => $lineTotal,
                    ]);

                    $product->decrement('stock_quantity', $qty);
                }

                UserNotification::create([
                    'user_id' => $order->farmer_id,
                    'title' => 'New cart pre-order',
                    'message' =>
                        'Order ' . $order->order_number .
                        ' is waiting for your approval.',
                    'type' => 'order',
                ]);

                $created[] = $order->id;
            }

            CartItem::where('user_id', auth()->id())->delete();
        });

        return redirect()
            ->route('customer.orders')
            ->with(
                'success',
                count($created) .
                ' order(s) placed successfully. Pay in person at pickup.'
            );
    }

}
