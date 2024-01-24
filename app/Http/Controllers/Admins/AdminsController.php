<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use App\Models\Admin;
use App\Models\Admin\Admin as Admin;
use App\Models\Category\Category;
use App\Models\Job\Job;
use App\Models\Job\Application;


use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminsController extends Controller
{
    //

    public function viewLogin(){

        return view("admins.view-login");
    }

    public function checkLogin(Request $request){

        $remember_me = $request->has('remember_me') ? true : false;

        if(auth()->guard('admin')->attempt(['email' => $request->input("email"), 'password' => $request->input("password")], $remember_me)){

            return redirect()->route('admins.dashboard');
        }

        return redirect()->back()->with(['error'=> 'error logging in']);
    }

    public function index(){

        $jobs = Job::select()->count();

        $categories = Category::select()->count();

        $admins = Admin::select()->count();

        $applications = Application::select()->count();


        return view("admins.index", compact('jobs', 'categories', 'admins', 'applications'));
    }

    public function admins(){

        $admins = Admin::all();

        return view("admins.all-admins", compact('admins'));
    }


    public function createAdmins(){

        return view("admins.create-admins");
    }

    public function storeAdmins(Request $request){

        Request()->validate([
            'name' =>"required|max:40",
            'email' =>"required|max:40",
            'password' =>"required"
        ]);

        $createAdmins = Admin::create([
            'name' =>$request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if($createAdmins){
            return redirect('admin/all-admins/')->with('create', 'Admin Created Successfully!');
        }
    }

    public function displayCategories(){

        $categories = Category::all();

        return view("admins.display-categories", compact('categories'));
    }

    public function createCategories(){

        return view("admins.create-categories");
    }


    public function storeCategories(Request $request){

        Request()->validate([
            'name' =>"required|max:40",
        ]);

        $createCategory = Category::create([
            'name' =>$request->name,
        ]);

        if($createCategory){
            return redirect('admin/display-categories')->with('create', 'Category Created Successfully!');
        }
    }


    public function editCategories($id){

        $category = Category::find($id);

        return view("admins.edit-categories", compact('category'));
    }



    public function updateCategories(Request $request, $id){

        Request()->validate([
            "name" =>'required|max:40',
        ]);


        $categoryUpdate = Category::find($id);
        $categoryUpdate->update([
            "name" => $request->name,
        ]);

        if($categoryUpdate){
            return redirect('/admin/display-categories/')->with('update', 'Category Updated Successfully!');
        }
    }

    public function deleteCategories($id){

        $deleteCategory = Category::find($id);
        $deleteCategory->delete();

        if($deleteCategory){
            return redirect('/admin/display-categories/')->with('delete', 'Category Deleted Successfully!');
        }
    }


    // jobs
    public function allJobs(){

       $jobs =Job::all();

       return view('admins.all-jobs', compact('jobs'));
    }


    public function createJobs(){

        $categories = Category::all();
        return view('admins.create-jobs', compact('categories'));
     }

     public function storeJobs(Request $request){

        //validate the data
        // Request()->validate([
        //     'name' =>"required|max:40",
        //     'email' =>"required|max:40",
        //     'password' =>"required"
        // ]);



        $destinationPath = 'assets/images/';
        $myimage = $request -> image->getClientOriginalName();
        $request->image->move(public_path($destinationPath), $myimage);

        $createJobs = Job::create([
            'job_title' =>$request->job_title,
            'job_region' => $request->job_region,
            'company' => $request->company,
            'job_type' => $request->job_type,
            'vacancy' => $request->vacancy,
            'experience' => $request->experience,
            'salary' => $request->salary,
            'gender' => $request->gender,
            'application_deadline' => $request->application_deadline,
            'job_description' => $request->job_description,
            'responsibilities' => $request->responsibilities,
            'education_experience' => $request->education_experience,
            'other_benefits' => $request->other_benefits,
            'category' => $request->category,
            'image' => $myimage,
        ]);

        if($createJobs){
            return redirect('admin/display-jobs/')->with('create', 'Job Created Successfully!');
        }
    }


}

