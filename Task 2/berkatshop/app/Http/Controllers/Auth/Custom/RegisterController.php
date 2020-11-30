<?php

namespace App\Http\Controllers\Auth\Custom;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\View\View;

class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        //
        return view('auth.register');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'username' => ['required', 'unique:users', 'max:50'],
            'email' => ['required', 'unique:users'],
            'phone' => ['required', 'unique:users'],
            'password' => ['required', 'confirmed'],
        ]);

        $userId = Str::uuid();
        $userLevel = $request->level != null ? $request->level : 0;
        $userRole = $request->role != null ? $request->role : 'MEMBER';

        DB::beginTransaction();
        try {
            $user = new User();
            $user->id = $userId;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->password = Hash::make($request->password);
            $user->role = $userRole;
            $user->level = $userLevel;
            $user->status = 1;

            if ($user->save()) {
                DB::commit();
                return redirect('login')->with('success', 'Account created. Try to login!');
            } else {
                return \Illuminate\Http\Response::create('Failed~!', 500);
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            $erMessage = $exception->getMessage();
            $erCode = $exception->getCode();
            return \Illuminate\Http\Response::create($erMessage.' : '.$erCode, 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
