<?php

namespace App\Http\Controllers\Jobs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job\Job;

class jobsController extends Controller
{
    public function single($id){


        $job = Job::find($id);

        return view('jobs.single', compact('job'));
    }
}
