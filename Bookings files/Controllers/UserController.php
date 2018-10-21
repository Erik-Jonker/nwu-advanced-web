<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getProfilePage(){
        return view('manageprofiles');
    }

    public function getAllProfiles()
    {
        return User::orderBy('name','asc')->get();
    }

    public function updateProfile(User $user, Request $request)
    {
        //Do not write empty values to the db
        if($request->name)
            $user->name = $request->name;

        if($request->email)
            $user->email = $request->email;

        if($request->cell)
            $user->cell = $request->cell;

        if($request->gender)
            $user->gender = $request->gender;
        
        if($request->role)
            $user->role = $request->role;

        if($request->updatePassword)
            $user->password = bcrypt($request->updatePassword);//encrypt password

        $user->save();

        return $user; //return the user so the view gets updated
    }
}
