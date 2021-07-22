<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    public function index() {
        $users = User::where('id', '!=', Auth::user()->id)->get();
        return view('user.list', compact('users'));
    }

    public function showCreate() {
        $roles = Role::all();
        return view('user.form', compact('roles'));
    }

    public function create(Request $request) {
        $validated = $request->validate([
            'username' => 'required|unique:users|max:255',
            'name' => 'required',
            'password' => 'required',
            'role' => 'required'
        ]);
        if ($validated) {
            try {

                $roleObj = Role::findorfail($request->role);

                $user = new User();
                $user->username = $request->username;
                $user->name = $request->name;
                $user->password = Hash::make($request->password);
                $user->save();

                $user->roles()->attach($roleObj);

            } catch(\Exception $e) {
                return Redirect::back()->withErrors(['SOmething went wrong!']);
            }
            return redirect('/users', Response::HTTP_CREATED);
        }
    }
    public function showEdit($id) {
        $roles = Role::all();
        $user = User::find($id);
        return view('user.form', compact('roles', 'user'));
    }
    public function edit(Request $request, $id) {
        $user = User::findorfail($id);
        $validated = $request->validate([
            'username' => 'required|unique:users,username, ' .  $id . ' |max:255',
            'name' => 'required',
            'password' => 'required',
            'role' => 'required'
        ]);
        try {
           
            if ($validated) {
                $roleObj = Role::findorfail($request->role);

                $user->username = $request->username;
                $user->name = $request->name;
                $user->password = Hash::make($request->password);
                $user->save();

                $user->roles()->sync($roleObj);

            
                return redirect('/users',  Response::HTTP_CREATED);
            }
        } catch(\Exception $e) {
            return Redirect::back()->withErrors(['SOmething went wrong!']);
        }
    }

    public function delete($id) {
        try {
            $user = User::findorfail($id);
            $user->delete();
            return redirect('/users', Response::HTTP_CREATED);
        } catch(\Exception $e) {
            return Redirect::back()->withErrors(['SOmething went wrong!']);
        }
    }
}
