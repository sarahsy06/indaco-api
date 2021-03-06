<?php

namespace Tests\Feature;
use Utilities\BaseRestTest;
use Faker\Factory as Faker;
use bheller\ImagesGenerator\ImagesGeneratorProvider;

class UserRestTest extends BaseRestTest
{
    protected $routes = '/api/users';
    
    protected $structure = [
        'id',
        'first_name',
        'last_name', 
        'email', 
        'password',
        'cities_id',
        'employee_id',
        'organization_id',
        'address',
        'username',
        'profile_picture',
        'phone_number',
        'deleted_at',
        'created_at',
        'updated_at'
    ];

    protected function getData(){
        $result = [];
        $faker = Faker::create('en_ZA');
        $faker->addProvider(new ImagesGeneratorProvider($faker));
        $result['first_name'] = $faker->firstName;
        $result['last_name'] = $faker->lastName;
        $result['email'] = $faker->email;
        $result['password'] = \Hash::make(12345678);
        $result['cities_id'] = rand(0, 100);
        $result['address'] = $faker->address;
        $result['phone_number'] = str_replace('-', '', str_replace(' ','',$faker->mobileNumber));
        return $result;
    }

    public function testLogin(){
        $response = $this->post('/api/login', [
            'email' => 'sarah061195@gmail.com',
            'password' => '12345678'
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [ 
                    'users' => $this->structure,
                    'token'
                ]
                ]);
    }

    public function testRegister(){
        $response = $this->post('/api/register', [
            'email'=> 'sarah061195@gmail.com', 
            'password'=> '0987654321',
            'phone_number'=> '081280133221',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [ 
                    'users' => $this->structure,
                    'token'
                ]
            ]);


        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [ 
                    'users' => $this->structure,
                    'token'
                ]
            ]);
    }
}