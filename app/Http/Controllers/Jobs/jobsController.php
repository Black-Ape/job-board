<?php

namespace App\Http\Controllers\Jobs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job\Job;
use App\Models\Category\Category;
use App\Models\Job\JobSaved;
use App\Models\Job\Application;
use Illuminate\Support\Facades\Auth;

class jobsController extends Controller
{
    public function single($id){


        $job = Job::find($id);

        //getting related jobs
        $relatedJobs = Job::where('category', $job->category)
        ->where('id', '!=', $id)
        ->take(5)
        ->get();

        //getting related jobs count
        $relatedJobsCount = Job::where('category', $job->category)
        ->where('id', '!=', $id)
        ->take(5)
        ->count();

        // $totalJobs = Job::all()->count();

        //save job
        $saveJob = JobSaved::where('job_id', $id)
        ->where('user_id', Auth::user()->id)
        ->count();

        //verify if user applied to the job
        $appliedJob = Application::where('user_id', Auth::user()->id)
        ->where('job_id', $id)
        ->count();

        //categories
        $categories = Category::all();

        return view('jobs.single', compact('job', 'relatedJobs', 'relatedJobsCount','saveJob', 'appliedJob', 'categories'));
    }

    public function saveJob(Request $request){

        $saveJob = jobSaved::create([
            'job_id' => $request->job_id,
            'user_id' => $request->user_id,
            'job_image' => $request->job_image,
            'job_title' => $request->job_title,
            'job_region' => $request->job_region,
            'job_type' => $request->job_type,
            'company' => $request->company
        ]);

        if($saveJob){
            return redirect('/jobs/single/'.$request->job_id.'')->with('save', 'job saved successfully!');
        }

    }

    public function jobApply(Request $request) {

        if($request->cv == 'No cv'){
            return redirect('/jobs/single/'.$request->job_id.'')->with('apply', 'upload your cv first in the profile page!');
        }else{
            $applyJob = Application::create([
                'cv' => Auth::user()->cv,
                'job_id' => $request->job_id,
                'user_id' => Auth::user()->id,
                'job_image' => $request->job_image,
                'job_title' => $request->job_title,
                'job_region' => $request->job_region,
                'job_type' => $request->job_type,
                'company' => $request->company

            ]);

            if($applyJob){
                return redirect('/jobs/single/'.$request->job_id.'')->with('applied', 'you applied to this job successfully!');
            }
        }
    }



}
