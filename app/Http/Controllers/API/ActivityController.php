<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Spatie\Activitylog\Models\Activity;

class ActivityController extends Controller
{
    public function index($userId=0)
    {
        if($userId){
            $activities = Activity::with('causer', 'subject')->where('causer_id', $userId)->get();
        }else {
            $activities = Activity::with('causer', 'subject')->orderBy('created_at', 'DESC')->simplePaginate(4);
        }
        return $activities;
    }
}
