<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Http\Model\User;
use App\Http\Model\Role;
use bheller\ImagesGenerator\ImagesGeneratorProvider;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('en_ZA');
        $faker->addProvider(new ImagesGeneratorProvider($faker));
        $role = new Role;
        $role->name = 'Administrator';
        $role->save();
        $role2 = new Role;
        $role2->name = 'Users';
        $role2->save();
        $user = new User();
        $user->first_name = 'John';
        $user->last_name = 'Doe';
        $user->email = 'john@doe.com';
        $user->password = \Hash::make(12345678);
        $user->cities_id = rand(0, 100);
        $user->address = $faker->address;
        $user->phone_number = '082214250262';
        $user->save();
        $user->roles()->attach($role2->id);
        foreach(range(0, 99) as $i){
            $user = new User;
            $user->first_name = $faker->firstName;
            $user->last_name = $faker->lastName;
            $user->email = $faker->email;
            $user->password = \Hash::make(12345678);
            $user->cities_id = rand(0, 100);
            $user->address = $faker->address;
            $user->phone_number = str_replace('-', '', str_replace(' ','',$faker->mobileNumber));
            $user->save();
            $user->roles()->attach($role2->id);
        }

        foreach(range(0, 99) as $i){
            $trainer = new Trainer;
            $trainer->name = $faker->name;
            $trainer->description = $faker->text;
            $trainer->save();
        }

    }
}
