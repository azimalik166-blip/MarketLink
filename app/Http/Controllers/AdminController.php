<?php

namespace App\Http\Controllers;

use App\Models\{User, Market, Product, Order, Category, Review, Announcement, ActivityLog};
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'farmers' => User::where('role','farmer')->count(),
            'customers' => User::where('role','customer')->count(),
            'markets' => Market::count(),
            'products' => Product::count(),
            'orders' => Order::count(),
            'pending' => Order::where('status','placed')->count(),
            'revenue' => Order::where('status','completed')->sum('total_amount'),
        ];
        $recent = Order::with(['customer','farmer'])->latest()->take(8)->get();
        $pendingFarmers = User::where('role','farmer')->where('status','pending')->count();
        return view('admin.dashboard', compact('stats','recent','pendingFarmers'));
    }

    public function users(Request $r)
    {
        $users = User::when($r->role,fn($q)=>$q->where('role',$r->role))
            ->when($r->status,fn($q)=>$q->where('status',$r->status))
            ->when($r->q,fn($q)=>$q->where(fn($x)=>$x->where('name','like','%'.$r->q.'%')->orWhere('email','like','%'.$r->q.'%')))
            ->latest()->paginate(20)->withQueryString();
        return view('admin.users',compact('users'));
    }

    public function exportUsers()
    {
        $users = User::orderBy('id')->get();
        return response()->streamDownload(function() use($users){
            $out=fopen('php://output','w'); fputcsv($out,['ID','Name','Email','Role','Status','Created']);
            foreach($users as $u) fputcsv($out,[$u->id,$u->name,$u->email,$u->role,$u->status,$u->created_at]);
            fclose($out);
        },'marketlink-users.csv',['Content-Type'=>'text/csv']);
    }

    public function userStatus(Request $r, User $user)
    {
        abort_unless($user->id !== auth()->id(), 422);
        $status = $r->validate(['status' => 'required|in:active,suspended'])['status'];
        $user->update(['status' => $status]);
        if ($user->role === 'farmer') {
            $user->farmerProfile?->update(['approval_status' => $status === 'active' ? 'approved' : 'suspended']);
        }
        ActivityLogger::log('admin.user.status','Changed '.$user->name.' status to '.$status,'User',$user->id);
        return back()->with('success', 'User status updated.');
    }

    public function farmerApproval(Request $r, User $user)
    {
        abort_unless($user->role==='farmer',404);
        $status=$r->validate(['status'=>'required|in:active,suspended'])['status'];
        $user->update(['status'=>$status]);
        $user->farmerProfile?->update(['approval_status'=>$status==='active'?'approved':'suspended']);
        ActivityLogger::log('admin.farmer.approval','Changed farmer '.$user->name.' status to '.$status,'User',$user->id);
        return back()->with('success','Farmer access updated.');
    }

    public function markets(){ return view('admin.markets',['markets'=>Market::withCount('products')->latest()->get()]); }

    public function storeMarket(Request $r)
    {
        $d=$r->validate(['name'=>'required|max:120','address'=>'required|max:255','days'=>'nullable|max:255','hours'=>'nullable|max:255','latitude'=>'nullable|numeric|between:-90,90','longitude'=>'nullable|numeric|between:-180,180']);
        $m=Market::create($d); ActivityLogger::log('admin.market.created','Created market '.$m->name,'Market',$m->id);
        return back()->with('success','Market created.');
    }

    public function updateMarket(Request $r, Market $market)
    {
        $d=$r->validate(['name'=>'required|max:120','address'=>'required|max:255','days'=>'nullable|max:255','hours'=>'nullable|max:255','latitude'=>'nullable|numeric|between:-90,90','longitude'=>'nullable|numeric|between:-180,180','is_active'=>'nullable|boolean']);
        $d['is_active']=$r->boolean('is_active');
        $market->update($d); ActivityLogger::log('admin.market.updated','Updated market '.$market->name,'Market',$market->id);
        return back()->with('success','Market updated.');
    }

    public function deleteMarket(Market $market){$name=$market->name;$id=$market->id;$market->delete();ActivityLogger::log('admin.market.deleted','Removed market '.$name,'Market',$id);return back()->with('success','Market removed.');}

    public function categories(){ return view('admin.categories',['categories'=>Category::withCount('products')->orderBy('name')->get()]); }

    public function storeCategory(Request $r){ $d=$r->validate(['name'=>'required|max:80|unique:categories,name']); Category::create(['name'=>$d['name'],'slug'=>Str::slug($d['name'])]); return back()->with('success','Category added.'); }

    public function deleteCategory(Category $category)
    {
        abort_if($category->products()->exists(), 422, 'Delete or move products in this category first.');
        $category->delete();
        return back()->with('success', 'Category deleted.');
    }

    public function moderation(){
        $products = Product::with('farmer')->latest()->paginate(10, ['*'], 'products_page')->withQueryString();
        $reviews = Review::with(['customer','farmer','product'])->latest()->paginate(10, ['*'], 'reviews_page')->withQueryString();
        return view('admin.moderation', compact('products', 'reviews'));
    }

    public function deleteProduct(Product $product){$name=$product->name;$id=$product->id;$product->delete();ActivityLogger::log('admin.moderation.product','Removed product listing '.$name,'Product',$id);return back()->with('success','Product listing removed.');}

    public function deleteReview(Review $review){$id=$review->id;$review->delete();ActivityLogger::log('admin.moderation.review','Removed review '.$id,'Review',$id);return back()->with('success','Review removed.');}

    public function announcements(){ return view('admin.announcements',['announcements'=>Announcement::latest()->get()]); }

    public function storeAnnouncement(Request $r){ $d=$r->validate(['title'=>'required|max:160','body'=>'required|max:3000']); Announcement::create($d + ['is_active'=>true]); return back()->with('success','Announcement published.'); }

    public function deleteAnnouncement(Announcement $announcement)
    {
        $announcement->delete();
        return back()->with('success', 'Announcement removed.');
    }

    public function reports()
    {
        $statusCounts=Order::selectRaw('status,COUNT(*) as total')->groupBy('status')->pluck('total','status');
        $revenue=Order::where('status','completed')->sum('total_amount');
        $orderCount=Order::whereNotIn('status',['cancelled','declined'])->count();
        $topProducts=Product::withCount('reviews')->withAvg('reviews','rating')->orderByDesc('reviews_count')->take(8)->get();
        $byMarket=Market::withCount('products')->orderBy('name')->get();
        $daily=Order::where('status','completed')->whereDate('created_at','>=',now()->subDays(6)->toDateString())->selectRaw('DATE(created_at) as day,SUM(total_amount) as total')->groupBy('day')->orderBy('day')->get();
        return view('admin.reports',compact('statusCounts','revenue','orderCount','topProducts','byMarket','daily'));
    }


    public function activity()
    {
        $logs = ActivityLog::with('user')->latest()->paginate(25);
        return view('admin.activity', compact('logs'));
    }

    public function exportOrders()
    {
        $orders=Order::with(['customer','farmer','market'])->latest()->get();
        return response()->streamDownload(function() use($orders){
            $out=fopen('php://output','w'); fputcsv($out,['Order','Customer','Farmer','Market','Pickup Date','Pickup Slot','Status','Total','Placed At']);
            foreach($orders as $o) fputcsv($out,[$o->order_number,$o->customer?->name,$o->farmer?->name,$o->market?->name,$o->pickup_date?->format('Y-m-d'),$o->pickup_slot,$o->status,$o->total_amount,$o->placed_at]);
            fclose($out);
        },'marketlink-orders.csv',['Content-Type'=>'text/csv']);
    }
}
