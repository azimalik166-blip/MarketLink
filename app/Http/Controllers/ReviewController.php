<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Review;
use App\Models\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\MarketLinkMailService;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'order_id'   => ['required', 'integer', 'exists:orders,id'],
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'rating'     => ['required', 'integer', 'min:1', 'max:5'],
            'comment'    => ['nullable', 'string', 'max:1000'],
        ]);

        $review = DB::transaction(function () use ($data) {
            $order = Order::with('items.product')
                ->whereKey($data['order_id'])
                ->where('customer_id', auth()->id())
                ->where('status', 'completed')
                ->firstOrFail();

            $item = $order->items->firstWhere(
                'product_id',
                (int) $data['product_id']
            );

            abort_unless(
                $item && $item->product,
                422,
                'This product was not included in your completed order.'
            );

            $review = Review::where('customer_id', auth()->id())
                ->where('product_id', $item->product_id)
                ->first();

            if (!$review) {
                $review = new Review([
                    'customer_id' => auth()->id(),
                    'product_id'  => $item->product_id,
                ]);
            }

            $review->farmer_id = $item->product->farmer_id;
            $review->rating = (int) $data['rating'];
            $review->comment = $data['comment'] ?? null;
            $review->save();

            return $review;
        });

        UserNotification::create([
            'user_id' => $review->farmer_id,
            'title'   => 'New customer review',
            'message' => 'A customer rated ' . ($review->product?->name ?? 'your product') . ' ' . $review->rating . '/5.',
            'type'    => 'review',
        ]);

        return back()->with('success', 'Review submitted successfully. Thank you!');
    }

    public function reply(Request $request, Review $review)
    {
        abort_unless($review->farmer_id === auth()->id(), 403);

        $data = $request->validate([
            'farmer_reply' => ['required', 'string', 'max:1000'],
        ]);

        $review->update([
            'farmer_reply' => trim($data['farmer_reply']),
        ]);

        $review->load('product');

        MarketLinkMailService::send($review->customer?->email, 'MarketLink · Farmer replied to your review', 'The farmer replied to your MarketLink review on '.($review->product?->name ?? 'a product').': '.trim($data['farmer_reply']));

        UserNotification::create([
            'user_id' => $review->customer_id,
            'title'   => 'Farmer replied to your review',
            'message' => 'The farmer replied to your review on ' . ($review->product?->name ?? 'a product') . '.',
            'type'    => 'review',
        ]);

        return back()->with('success', 'Reply published successfully.');
    }
}
