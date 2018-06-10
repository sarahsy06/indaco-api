<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    protected $table = 'password_resets';
    
    protected $primaryKey = 'token';
    public $timestamps = false;
    
    protected $fillable = [ 
        'email', 
        'token', 
        'created_at'
    ];


    protected $rules =  [
        'store' => [
            'email' => 'required'
        ],
    ];

    public function getRules($key = null)
    {
        if ($key != null && array_key_exists($key, $this->rules)) {
            return $this->rules[$key];
        } else {
            return [];
        }
    }
}
