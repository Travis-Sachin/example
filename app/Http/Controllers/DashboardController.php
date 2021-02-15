<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

use Auth;
use Illuminate\Support\Facades\Redirect;

class DashboardController extends Controller
{
    //

    protected $role;
    protected $admin_id="admin_id";
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->role = auth()->user()->role->name;
            return $next($request);
        });
    }
    /**
     * Returns Dashboard of User
     *
     * @return void
     */
    public function user()
    {
        $data= ['role' => $this->role];


        if(session()->has($this->admin_id))
            $data['admin']= User::find(session()->get($this->admin_id));

        return Inertia::render('Dashboard', $data);
    }
    /**
     * Returns Dashboard of Admin
     *
     * @return void
     */
    public function admin()
    {
        return Inertia::render('Dashboard', ['role' => $this->role]);
    }
    /**
     * Returns Dashboard of Super Admin
     *
     * @return void
     */
    public function superAdmin()
    {

        $users = User::whereHas('role', function ($query) {
            $query->where('name', 'user');
        })->get();
        return Inertia::render('Dashboard', ['role' => $this->role, 'users' => $users]);
    }
    /**
     * uploader
     *
     * @param  Request $request
     * @return void
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

    public function simulate($slug, Request $request)
    {
        $user = User::find($slug);

        session([$this->admin_id => Auth::id()]);
        
        Auth::login($user);
        return redirect()->route('dashboard');
    }
    public function endSimulation(Request $request)
    {
        if(!session()->has($this->admin_id)){
            return redirect()->back()->with('error', 'No Simulation');
        }
        $admin= User::find(session()->get($this->admin_id));
        Auth::login($admin);
        return redirect()->route('dashboard');
    }
}
