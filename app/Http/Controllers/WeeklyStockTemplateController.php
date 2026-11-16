<?php
namespace App\Http\Controllers;
use App\Models\{WeeklyStockTemplate,Category,Market,Product};
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Services\ActivityLogger;
class WeeklyStockTemplateController extends Controller {
    public function index(){ $templates=WeeklyStockTemplate::with(['category','market'])->where('farmer_id',auth()->id())->latest()->get();$categories=Category::orderBy('name')->get();$markets=Market::where('is_active',1)->orderBy('name')->get();return view('farmer.weekly-templates',compact('templates','categories','markets')); }
    public function store(Request $r){$d=$r->validate(['name'=>'required|max:100','category_id'=>'required|exists:categories,id','market_id'=>'nullable|exists:markets,id','description'=>'nullable|max:2000','price'=>'required|numeric|min:0','unit'=>'required|max:50','target_quantity'=>'required|integer|min:0|max:100000']);WeeklyStockTemplate::create($d+['farmer_id'=>auth()->id(),'is_active'=>true]);return back()->with('success','Weekly stock template saved.');}
    public function update(Request $r,WeeklyStockTemplate $template){abort_unless($template->farmer_id===auth()->id(),403);$d=$r->validate(['name'=>'required|max:100','category_id'=>'required|exists:categories,id','market_id'=>'nullable|exists:markets,id','description'=>'nullable|max:2000','price'=>'required|numeric|min:0','unit'=>'required|max:50','target_quantity'=>'required|integer|min:0|max:100000']);$template->update($d);return back()->with('success','Template updated.');}
    public function apply(WeeklyStockTemplate $template){abort_unless($template->farmer_id===auth()->id(),403);$p=Product::firstOrNew(['farmer_id'=>auth()->id(),'name'=>$template->name,'market_id'=>$template->market_id]);$p->category_id=$template->category_id;$p->description=$template->description;$p->price=$template->price;$p->unit=$template->unit;$p->stock_quantity=$template->target_quantity;$p->is_available=$template->target_quantity>0;$p->slug=$p->slug?:Str::slug($template->name.'-'.uniqid());$p->save();ActivityLogger::log('stock.template.applied','Applied weekly template '.$template->name,'WeeklyStockTemplate',$template->id);return back()->with('success','Template applied to your current stock.');}
    public function destroy(WeeklyStockTemplate $template){abort_unless($template->farmer_id===auth()->id(),403);$template->delete();return back()->with('success','Template removed.');}
}
