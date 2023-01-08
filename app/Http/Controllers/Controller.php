<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Define a method to add new log
     * @param $title Contains the title of the activity
     * @param $description Contains the description of the activity
     * @return Void
     */
    public function addLog( $title, $description ) {
        $newActivityLog = new ActivityLog;
        $newActivityLog->user_id = auth()->user()->id;
        $newActivityLog->title = $title;
        $newActivityLog->description = $description;
        $newActivityLog->save();
    }
}
