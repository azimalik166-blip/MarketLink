<?php

namespace App\Http\Controllers;

use App\Models\{PickupSlot,Market};
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PickupSlotController extends Controller
{
    public function index(){
        $slots=PickupSlot::with('market')->where('farmer_id',auth()->id())->whereDate('slot_date','>=',today())->orderBy('slot_date')->orderBy('start_time')->get();
        $markets=Market::where('is_active',true)->orderBy('name')->get();
        return view('farmer.pickup-slots',compact('slots','markets'));
    }
    public function store(Request $request){
        $d=$request->validate(['market_id'=>['nullable','exists:markets,id'],'slot_date'=>['required','date','after_or_equal:today'],'start_time'=>['required','date_format:H:i'],'end_time'=>['required','date_format:H:i','after:start_time'],'capacity'=>['required','integer','min:1','max:100']]);
        $overlap=PickupSlot::where('farmer_id',auth()->id())->whereDate('slot_date',$d['slot_date'])->when($d['market_id']??null,fn($q)=>$q->where('market_id',$d['market_id']),fn($q)=>$q->whereNull('market_id'))->where(function($q)use($d){$q->where('start_time','<',$d['end_time'])->where('end_time','>',$d['start_time']);})->exists();
        abort_if($overlap,422,'This pickup window overlaps an existing slot.');
        PickupSlot::create($d+['farmer_id'=>auth()->id(),'is_active'=>true]);
        return back()->with('success','Pickup slot created.');
    }
    public function destroy(PickupSlot $pickupSlot){abort_unless($pickupSlot->farmer_id===auth()->id(),403);$pickupSlot->delete();return back()->with('success','Pickup slot removed.');}
}
