<?php

use Illuminate\Database\Seeder;

use App\Authorizations;

class AuthorizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Authorizations::create([
            'authorization_key' => '5f304f00bd846854a2f99e885c2c86cbf3755433fd6c804ab21e4d5400a97949'
        ]);
    }
}
