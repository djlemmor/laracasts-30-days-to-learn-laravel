<?php

use App\Models\Job;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Route::get('/about', function () {
    return view('about');
});

// Index
Route::get('/jobs', function ()  {
    $jobs= Job::with(   'employer')->latest()->paginate(6);

    return view('jobs.index', [
        'jobs' => $jobs
    ]);
});

// Create
Route::get('/jobs/create', function () {
    return view('jobs.create');
});

// Show
Route::get('/jobs/{id}', function ($id)  {
    $job = Job::find($id);

    return view('jobs.show',  ['job' => $job]);
});

// Store
Route::post('/jobs  ', function () {
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
});

// Edit
Route::get('/jobs/{id}/edit', function ($id)  {
    $job = Job::find($id);

    return view('jobs.edit',  ['job' => $job]);
});

// Update
Route::patch('/jobs/{id}', function ($id)  {
    // validate
    request()->validate([
        'title' => ['required', 'min: 5'],
        'salary' => ['required'],
    ]);

    // authorizate (on hold)

    // update the job and persist
    $job = Job::findOrFail($id);
    
    $job->update([
        'title'=> request('title'),
        'salary'=> request('salary'),
    ]);

    // redirect
    return redirect('/jobs/' . $job->id);
});

// Destroy
Route::delete('/jobs/{id}', function ($id)  {
    // authorizate (on hold)
    
    // delete the job
    $job = Job::findOrFail($id);
    $job->delete();

    // redirect
    return redirect('/jobs');
});

Route::get('/contact', function () {
    return view('contact');
});
