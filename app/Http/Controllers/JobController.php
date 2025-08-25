<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    public function index() {
       $jobs= Job::with('employer')->latest()->paginate(6);

        return view('jobs.index', [
            'jobs' => $jobs
        ]);
    }

    public function create() {
        return view('jobs.create');
    }

    public function show(Job $job) {
        return view('jobs.show', ['job' => $job]); 
    }

    public function store(Request $request) {
        request()->validate([
            'title' => ['required', 'min: 5'],
            'salary' => ['required'],
        ]);

        Job::create([
            'title' => request('title'),
            'salary' => request('salary'),
            'employer_id' => 1,
        ]);

    return redirect('/jobs');
    }

    public function edit(Job $job) {
        return view('jobs.edit', ['job' => $job]);
    }

    public function update(Request $request, Job $job) {
        // validate
        request()->validate([
            'title' => ['required', 'min: 5'],
            'salary' => ['required'],
        ]);

        // authorizate (on hold)

        // update the job and persist
        $job->update([
            'title'=> request('title'),
            'salary'=> request('salary'),
        ]);

        // redirect
        return redirect('/jobs/' . $job->id);
    }

    public function destroy(Job $job) {  
        // authorizate (on hold)
    
        // delete the job
        $job->delete();

        // redirect
        return redirect('/jobs');
    }
}
