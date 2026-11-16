<?php
namespace App\Http\Controllers;
use App\Models\{Product,Category,Market,Order,Review,UserNotification,PickupSlot,User,OrderItem,WeeklyStockTemplate};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\ActivityLogger;
class FarmerController extends Controller {
    public function dashboard(){
        $farmer=auth()->user();$ordersBase=fn()=> $farmer->farmerOrders();
        $stats=['products'=>$farmer->products()->count(),'available'=>$farmer->products()->where('is_available',1)->where('stock_quantity','>',0)->count(),'low_stock'=>$farmer->products()->where('stock_quantity','<=',5)->count(),'orders'=>$ordersBase()->count(),'pending'=>$ordersBase()->where('status','placed')->count(),'accepted'=>$ordersBase()->where('status','accepted')->count(),'ready'=>$ordersBase()->where('status','ready')->count(),'completed'=>$ordersBase()->where('status','completed')->count(),'revenue'=>$ordersBase()->whereIn('status',['accepted','ready','completed'])->sum('total_amount'),'completed_revenue'=>$ordersBase()->where('status','completed')->sum('total_amount'),'rating'=>round((float)Review::where('farmer_id',$farmer->id)->avg('rating'),1),'pickup_slots'=>PickupSlot::where('farmer_id',$farmer->id)->whereDate('slot_date','>=',today())->where('is_active',1)->count()];
        $products=$farmer->products()->with(['category','market'])->latest()->take(8)->get();$orders=$farmer->farmerOrders()->with('customer')->latest()->take(7)->get();$reviews=Review::with(['customer','product'])->where('farmer_id',$farmer->id)->latest()->take(8)->get();$notifications=UserNotification::where('user_id',$farmer->id)->whereNull('read_at')->latest()->take(4)->get();
        $salesStart = now()->subDays(6)->startOfDay();
        $sales = $ordersBase()->where('status','completed')->where('placed_at','>=',$salesStart)->selectRaw('DATE(placed_at) as day,SUM(total_amount) as total')->groupBy('day')->orderBy('day')->get()->keyBy(fn($row)=>(string)$row->day);
        $salesDates = collect(range(6,0))->map(fn($days)=>now()->subDays($days)->startOfDay());
        $salesLabels = $salesDates->map(fn($date)=>$date->format('d M'));
        $salesValues = $salesDates->map(fn($date)=>(float)($sales[$date->toDateString()]->total ?? 0));
        $topProducts=OrderItem::select('product_id',DB::raw('SUM(quantity) as sold_qty'),DB::raw('SUM(line_total) as sold_value'))->whereHas('order',fn($q)=>$q->where('farmer_id',$farmer->id)->where('status','completed'))->groupBy('product_id')->with('product')->orderByDesc('sold_qty')->take(5)->get();
        return view('farmer.dashboard',compact('stats','products','orders','reviews','notifications','salesLabels','salesValues','topProducts'));
    }
    public function profile(){return view('farmer.profile',['profile'=>auth()->user()->farmerProfile,'markets'=>Market::where('is_active',1)->orderBy('name')->get()]);}
    public function updateProfile(Request $r){$d=$r->validate(['stall_name'=>'required|max:100','bio'=>'nullable|max:2000','operating_days'=>'nullable|max:255','pickup_windows'=>'nullable|max:255','order_cutoff_time'=>'nullable|date_format:H:i','address'=>'required|max:255','latitude'=>'nullable|numeric|between:-90,90','longitude'=>'nullable|numeric|between:-180,180']);auth()->user()->farmerProfile()->update($d);ActivityLogger::log('farmer.profile.updated','Updated farmer profile','FarmerProfile',auth()->id());return back()->with('success','Farmer profile updated.');}
    public function products(){return view('farmer.products',['products'=>auth()->user()->products()->with(['category','market'])->latest()->get(),'categories'=>Category::orderBy('name')->get(),'markets'=>Market::where('is_active',1)->orderBy('name')->get()]);}
    public function publicShow(User $user){abort_unless($user->role==='farmer'&&$user->status==='active',404);$user->load('farmerProfile');abort_unless($user->farmerProfile&&$user->farmerProfile->approval_status==='approved',404);$products=Product::with(['category','market','reviews'])->where('farmer_id',$user->id)->where('is_available',1)->where('stock_quantity','>',0)->latest()->paginate(12);$reviews=Review::with('customer')->where('farmer_id',$user->id)->latest()->take(8)->get();$rating=round((float)Review::where('farmer_id',$user->id)->avg('rating'),1);$isFavorite=auth()->check()&&auth()->user()->role==='customer'?\App\Models\Favorite::where('user_id',auth()->id())->where('farmer_id',$user->id)->exists():false;return view('farmers.show',compact('user','products','reviews','rating','isFavorite'));}
    public function salesExport(){
        $orders=auth()->user()->farmerOrders()->with(['customer','items.product'])->where('status','completed')->latest()->get();
        return response()->streamDownload(function()use($orders){$o=fopen('php://output','w');fputcsv($o,['Order','Customer','Date','Items','Total']);foreach($orders as $ord){fputcsv($o,[$ord->order_number,$ord->customer->name,$ord->pickup_date->format('Y-m-d'),$ord->items->pluck('product.name')->join(' | '),$ord->total_amount]);}fclose($o);},'marketlink-farmer-sales.csv',['Content-Type'=>'text/csv']);
    }
}
