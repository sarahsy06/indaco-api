<?php

namespace App\Http\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name', 
        'email', 
        'phone_number',
        'password',
        'address',        
        'cities_id',
        'provinces_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $rules = [
        "store" => [
            "first_name" => "required",
            "phone_number" => "required|unique:users|min:7",
            "email" => "required|unique:users|email",
            "password"=>"required|confirmed",
        ],
        "update" => []
    ];
    
    public function getRules($key = null)
    {
        if ($key != null && array_key_exists($key, $this->rules)) {
            return $this->rules[$key];
        } else {
            return [];
        }
    }
    public function setPasswordAttribute($value){
        $this->attributes['password'] = \Hash::make($value);
    }

}
