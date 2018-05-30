<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Role extends Model
{
    use Sluggable;
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'phone_number'
            ]
        ];
    }

    protected $fillable = [
        'phone_number', 'description'
    ];

    protected $rules = [
        "store" => [
            "phone_number" => "required"
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

    public function users(){
        return $this->belongsToMany('App\Http\Model\User');
    }

    protected $transformer = 'App\Http\Transformer\RolesTransformer';

        public function getTransformer(){
            return app($this->transformer); // Which need to be instantiated from League\Fractal\TransformerAbstract
        }  
}