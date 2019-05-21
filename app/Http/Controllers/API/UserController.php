<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::latest()->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'   =>  'required|string|between:4,190',
            'email'   =>  'required|string|email|max:191|unique:users',
            'password'   =>  'required|string|between:4,191',
            'bio'   =>  'required|string|min:5',
        ]);
        return User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'bio' => $request['bio'],
            'type' => $request['type'],
            'password' => Hash::make($request['password']),

        ]);
        //return $request->all();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Display the specified profile.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        $user = \Auth::user();
        return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrfail($id);

        $this->validate($request, [
            'name'   =>  'required|string|between:4,190',
            'email'   =>  'required|string|email|max:191|unique:users,email,'.$user->id,
            'password'   =>  'sometimes|string|between:4,191',
            'bio'   =>  'required|string|min:5',
        ]);

        $user->update($request->all());

        return ['message' => 'user updated'];
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return ['message' => "L'utilisateur a été supprimé"];
    }
}
