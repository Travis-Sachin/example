<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    //

    protected $role;
    function __construct() {
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
        return Inertia::render('Dashboard', ['role' => $this->role]);
    } 
     /**
     * Returns Dashboard of Super Admin
     *
     * @return void
     */
    public function super_admin()
    {
     
        $users= User::whereHas('role',function($query){
            $query->where('name','user');
        })->get();
        return Inertia::render('Dashboard', ['role' => $this->role, 'users'=> $users]);
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
}
