<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

use Auth;
use Illuminate\Support\Facades\Redirect;

/**
 * DashboardController to return dashboards of every user
 */
class DashboardController extends Controller
{
    //

    protected $adminId = "admin_id";

    /**
     * Returns Dashboard of User
     * @param 
     * @return Illuminate\Support\Facades\Response
     */
    public function user()
    {
        $role = $this->getRole();
        return Inertia::render('Dashboard', compact('role'));
    }
    /**
     * Returns Dashboard of Author
     * @param 
     * @return Illuminate\Support\Facades\Response
     */
    public function author()
    {
        $role = $this->getRole();
        return Inertia::render('Dashboard', compact('role'));
    }
    /**
     * Returns Dashboard of Admin
     * @param 
     * @return Illuminate\Support\Facades\Response
     */
    public function admin()
    {
        $role = $this->getRole();
        return Inertia::render('Dashboard', compact('role'));
    }
    /**
     * Returns Dashboard of Super Admin
     * @param 
     * @return Illuminate\Support\Facades\Response
     */
    public function superAdmin()
    {
        $role = $this->getRole();
        $users = User::whereHas('role', function ($query) {
            $query->where('name', 'user');
        })->get();
        return Inertia::render('Dashboard', compact('role', 'users'));
    }
    /**
     * To upload images
     *
     * @param  \App\Http\Requests\UploadRequest $request
     * @return \Illuminate\Support\Facades\Response
     */
    public function uploader(UploadRequest $request)
    {
        $validated = $request->validated();
        $file = $request->file('photo')->store('images');
        $user = User::find(Auth::id());
        $user->profile_photo_path = pathinfo($file)['basename'];
        $user->save();
        return redirect()->back()->with('success', 'Image uploaded');
    }
    /**
     * To simulate login of end-user by Admin
     *
     * @param  mixed $slug
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Support\Facades\Response
     */    
    
    public function simulate($slug, Request $request)
    {
        $user = User::find($slug);

        session([$this->adminId => Auth::id()]);

        Auth::login($user);
        return redirect()->route('dashboard');
    }
    /**
     * To simulate login of end-user by Admin
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Support\Facades\Response
     */
    public function endSimulation(Request $request)
    {
        if (!session()->has($this->adminId)) {
            return redirect()->back()->with('error', 'No Simulation');
        }
        $admin = User::find(session()->get($this->adminId));
        Auth::login($admin);
        return redirect()->route('dashboard');
    }
    public function getRole()
    {
        return auth()->user()->role->name;
    }
}
