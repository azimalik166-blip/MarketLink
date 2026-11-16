<?php
namespace App\Http\Controllers;
use App\Models\{Product,Category,Market,Favorite,User,Review};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Services\ActivityLogger;
use App\Models\UserNotification;
class ProductController extends Controller {
    public function index(Request $r){
        $sort=$r->input('sort','latest'); $allowed=['latest','price_low','price_high','name','top_rated']; abort_unless(in_array($sort,$allowed,true),422);
        $products=Product::with(['farmer.farmerProfile','category','market'])->withCount('reviews')->withAvg('reviews','rating')->where('is_available',true)->where('stock_quantity','>',0)
            ->when($r->q,fn($q)=>$q->where(fn($x)=>$x->where('name','like','%'.$r->q.'%')->orWhere('description','like','%'.$r->q.'%')))
            ->when($r->category,fn($q)=>$q->where('category_id',$r->category))->when($r->market,fn($q)=>$q->where('market_id',$r->market))->when($r->farmer,fn($q)=>$q->where('farmer_id',$r->farmer))
            ->when($r->min_price!==null&&$r->min_price!=='',fn($q)=>$q->where('price','>=',max(0,(float)$r->min_price)))
            ->when($r->max_price!==null&&$r->max_price!=='',fn($q)=>$q->where('price','<=',max(0,(float)$r->max_price)));
        $products=match($sort){ 'price_low'=>$products->orderBy('price'),'price_high'=>$products->orderByDesc('price'),'name'=>$products->orderBy('name'),'top_rated'=>$products->orderByDesc('reviews_avg_rating')->orderByDesc('created_at'),default=>$products->latest()};
        $products=$products->paginate(12)->withQueryString(); $categories=Category::orderBy('name')->get(); $markets=Market::where('is_active',1)->orderBy('name')->get();
        $farmers=User::where('role','farmer')->where('status','active')->whereHas('farmerProfile',fn($q)=>$q->where('approval_status','approved'))->with('farmerProfile')->orderBy('name')->get();
        $favoriteProductIds=auth()->check()&&auth()->user()->role==='customer'?Favorite::where('user_id',auth()->id())->whereNotNull('product_id')->pluck('product_id'):collect();
        return view('products.index',compact('products','categories','markets','farmers','favoriteProductIds'));
    }
    public function show(Product $product){
        $product->load(['farmer.farmerProfile','category','market','reviews.customer']);
        if(auth()->check()){$recent=collect(session('marketlink_recent_products',[]))->reject(fn($id)=>(int)$id===$product->id)->prepend($product->id)->unique()->take(8)->values()->all();session(['marketlink_recent_products'=>$recent]);}
        $isFavorite=auth()->check()&&auth()->user()->role==='customer'?Favorite::where('user_id',auth()->id())->where('product_id',$product->id)->exists():false;
        $related=Product::with(['category','farmer'])->withAvg('reviews','rating')->where('category_id',$product->category_id)->where('id','!=',$product->id)->where('is_available',1)->where('stock_quantity','>',0)->latest()->take(4)->get();
        $recentIds=collect(session('marketlink_recent_products',[]))->filter(fn($id)=>(int)$id!==$product->id)->take(4);
        $recentProducts=$recentIds->isEmpty()?collect():Product::with(['category','farmer'])->whereIn('id',$recentIds)->where('is_available',1)->where('stock_quantity','>',0)->get()->sortBy(fn($p)=>array_search($p->id,$recentIds->all()))->values();
        return view('products.show',compact('product','isFavorite','related','recentProducts'));
    }
    public function compare(Request $r){
        $ids=collect($r->input('ids',[]))->map(fn($v)=>(int)$v)->filter()->unique()->take(4)->values(); abort_if($ids->count()<2,422,'Choose at least two products to compare.');
        $products=Product::with(['farmer.farmerProfile','category','market'])->withAvg('reviews','rating')->whereIn('id',$ids)->get()->sortBy(fn($p)=>array_search($p->id,$ids->all()))->values();
        return view('products.compare',compact('products'));
    }
    public function store(Request $r){
        $d=$r->validate(['name'=>'required|max:100','category_id'=>'required|exists:categories,id','market_id'=>'nullable|exists:markets,id','description'=>'nullable|max:3000','price'=>'required|numeric|min:0','unit'=>'required|max:50','stock_quantity'=>'required|integer|min:0','image'=>'nullable|image|max:2048']);
        $d['farmer_id']=auth()->id();$d['slug']=Str::slug($d['name'].'-'.uniqid());$d['is_available']=true;if($r->hasFile('image'))$d['image']=$r->file('image')->store('products','public');$p=Product::create($d);$this->notifyRestock($p,0,(int)$p->stock_quantity);ActivityLogger::log('product.created','Added product '.$p->name,'Product',$p->id);return back()->with('success','Product added to your weekly stock.');
    }
    public function update(Request $r,Product $product){
        abort_unless($product->farmer_id===auth()->id(),403);$oldStock=(int)$product->stock_quantity;
        $d=$r->validate(['name'=>'required|max:100','category_id'=>'required|exists:categories,id','market_id'=>'nullable|exists:markets,id','description'=>'nullable|max:3000','price'=>'required|numeric|min:0','unit'=>'required|max:50','stock_quantity'=>'required|integer|min:0','image'=>'nullable|image|max:2048']);
        if($r->hasFile('image'))$d['image']=$r->file('image')->store('products','public');$d['is_available']=$r->boolean('is_available')&&(int)$d['stock_quantity']>0;$product->update($d);$this->notifyRestock($product,$oldStock,(int)$product->stock_quantity);ActivityLogger::log('product.updated','Updated product '.$product->name,'Product',$product->id);return back()->with('success','Product updated.');
    }
    public function destroy(Product $product){abort_unless($product->farmer_id===auth()->id(),403);$name=$product->name;$id=$product->id;$product->delete();ActivityLogger::log('product.deleted','Removed product '.$name,'Product',$id);return back()->with('success','Product removed.');}
    private function notifyRestock(Product $product,int $old,int $new):void{
        if($new<=0||($old>0&&$new<=$old))return;
        $ids=Favorite::whereNotNull('product_id')->where('product_id',$product->id)->pluck('user_id')->merge(Favorite::whereNotNull('farmer_id')->where('farmer_id',$product->farmer_id)->pluck('user_id'))->unique();
        foreach($ids as $uid) UserNotification::create(['user_id'=>$uid,'title'=>'Back in stock','message'=>$product->name.' is available again.','type'=>'stock']);
    }
}
