<?php

namespace App\Http\Controllers;

use App\Models\{Product, Market, User, Order};
use Illuminate\Http\Request;

class AssistantController extends Controller
{
    public function ask(Request $r)
    {
        $q=trim($r->input('message',''));
        if($q==='') return response()->json(['answer'=>'Ask me about products, markets, pickup, farmers, cart, or your orders.']);
        $text=mb_strtolower($q);

        if(auth()->user()->role==='customer' && (str_contains($text,'my order')||str_contains($text,'my orders')||str_contains($text,'order status'))){
            $orders=Order::where('customer_id',auth()->id())->latest()->take(5)->get();
            return response()->json(['answer'=>$orders->count()?'Here are your latest orders.':'You do not have any orders yet.','orders'=>$orders->map(fn($o)=>['number'=>$o->order_number,'status'=>ucfirst($o->status),'pickup'=>$o->pickup_date->format('d M Y').' · '.$o->pickup_slot])]);
        }

        if(str_contains($text,'cart')) {
            if (auth()->user()->role === 'customer') return response()->json(['answer'=>'Open your cart to review quantities, then checkout.','url'=>route('cart.index')]);
            return response()->json(['answer'=>'The shopping cart is available for customer accounts.']);
        }

        $products=Product::with(['farmer','category'])->where('is_available',1)->where('stock_quantity','>',0)->where(fn($x)=>$x->where('name','like','%'.$q.'%')->orWhere('description','like','%'.$q.'%'))->take(6)->get();
        if($products->count()) return response()->json(['answer'=>'I found available products matching your request.','results'=>$products->map(fn($p)=>['name'=>$p->name,'price'=>'Rs '.number_format($p->price,2),'farmer'=>$p->farmer->name,'id'=>$p->id])]);

        if(str_contains($text,'market')||str_contains($text,'timing')||str_contains($text,'open')){ $m=Market::where('is_active',1)->take(6)->get(); return response()->json(['answer'=>'Here are active markets and their published timings.','markets'=>$m->map(fn($x)=>['name'=>$x->name,'hours'=>$x->hours,'days'=>$x->days])]); }
        if(str_contains($text,'farmer')){ $f=User::where('role','farmer')->where('status','active')->with('farmerProfile')->take(6)->get(); return response()->json(['answer'=>'These farmers currently have active profiles.','farmers'=>$f->map(fn($x)=>['name'=>$x->farmerProfile?->stall_name??$x->name,'address'=>$x->farmerProfile?->address,'id'=>$x->id])]); }
        if(str_contains($text,'pickup')||str_contains($text,'pay')) return response()->json(['answer'=>'MarketLink uses pre-orders for pickup. Online payment is not required; pay the farmer in person when you collect your order.']);
        return response()->json(['answer'=>'Try: “Show tomatoes”, “What markets are open?”, “Show available farmers”, “What is my order status?”, “Open my cart”, or “How does pickup work?”']);
    }
}
