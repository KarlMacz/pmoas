<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(AuthorizationSeeder::class);
        $this->call(EmployeeSeeder::class);
        $this->call(ClientSeeder::class);
        $this->call(ProductSeeder::class);
    }
}
