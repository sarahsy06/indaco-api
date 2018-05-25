<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    
        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = [
            'name','longitude','latitude','image'
        ];

        protected $rules = [
            "store" => [
                "name" => "required",
                "latitude" => "required",
                "longitude" => "required",
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
    
}