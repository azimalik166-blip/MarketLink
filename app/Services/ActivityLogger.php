<?php
namespace App\Services;
use App\Models\ActivityLog;
class ActivityLogger {
    public static function log(string $action,string $description,?string $entityType=null,?int $entityId=null): void {
        try { ActivityLog::create(['user_id'=>auth()->id(),'action'=>$action,'description'=>substr($description,0,500),'entity_type'=>$entityType,'entity_id'=>$entityId,'ip_address'=>request()->ip()]); } catch (\Throwable $e) { report($e); }
    }
}
