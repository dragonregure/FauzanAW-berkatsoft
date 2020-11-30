<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable;

    public $fillable = ['id'];
    public $incrementing = false;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function login(array $data) {
        if ($account = self::checkUsername($data['username'])) {
            !isset($data['remember']) ? $remember = null : $remember = $data['remember'];
            if ($auth = Auth::attempt(['username' => $data['username'], 'password' => $data['password']], $remember)) {
                return $auth;
            } elseif ($auth = Auth::attempt(['email' => $data['username'], 'password' => $data['password']], $remember)) {
                return $auth;
            } else {
                session(['wrongpass' => 'Incorrect password!']);
                return $auth;
            }
        } else {
            session(['noaccountav' => 'No account found with the Username/Email!']);
            return false;
        }
    }

    public static function checkUsername(string $username) {
        if (self::getByUserName($username) != null) {
            return self::getByUserName($username);
        } elseif (self::getByEmail($username) != null) {
            return self::getByEmail($username);
        } else {
            return false;
        }
    }

    public static function getByUserName(string $username) {
        return self::where('username', $username)->first();
    }

    public static function getByEmail(string $email) {
        return self::where('email', $email)->first();
    }
}
