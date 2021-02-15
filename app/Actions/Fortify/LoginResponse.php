<?php
namespace App\Actions\Fortify;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{

    /**
     * @inheritDoc
     */
    public function toResponse($request)
    {
        $home= $request->user()->role->name;
        return $request->wantsJson()
            ? response()->json(['two_factor' => false])
            : redirect()->route($home=='user'?'dashboard':$home.".dashboard"); // This is the line you want to modify so the application behaves the way you want.
    }
}