<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => ['required', 'string', 'max:50', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:50', 'unique:users'],
            'phone' => ['required', 'string', 'max:15', 'unique:users'],
            'type' => ['required', 'string', 'max:10'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        //        dd($data);
        DB::beginTransaction();
        try {
            $model = new User();
            $id = Str::uuid();
            $model->id = $id;
            $model->username = $data['username'];
            $model->email = $data['email'];
            $model->phone = $data['phone'];
            $model->password = Hash::make($data['password']);
            $model->role = 'MEMBER';
            $model->level = 0;
            $model->type = $data['type'];
            $model->rightpost = 0;
            $model->wrongpost = 0;
            $model->reputation = 0;
            $model->status = 1;
            if ($model->save()) {
                return $model;
            } else {
                throw new \Exception($model->errors,500);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
        }


//        return User::create([
//            'id' => $id,
//            'username' => $data['username'],
//            'email' => $data['email'],
//            'phone' => $data['phone'],
//            'password' => Hash::make($data['password']),
//            'role' => 'MEMBER',
//            'level' => 0,
//            'type' => $data['type'],
//            'rightpost' => 0,
//            'wrongpost' => 0,
//            'reputation' => 0,
//            'status' => 1,
//        ]);
    }
}
