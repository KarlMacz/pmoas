<?php

use Illuminate\Database\Seeder;

use App\Accounts;
use App\Clients;
use App\Passwords;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $account = Accounts::create([
            'username' => 'client',
            'email' => 'client.juanito@gmail.com',
            'password' => bcrypt('client'),
            'is_verified' => true,
            'role' => 'Client'
        ]);

        if($account) {
            Passwords::create([
                'identifier' => hash('sha256', 'client'),
                'password' => 'client'
            ]);

            Clients::create([
                'account_id' => $account->id,
                'first_name' => 'Juanito',
                'last_name' => 'Panchito',
                'birth_date' => '2000-01-01',
                'address' => '',
                'gender' => 'Male',
                'contact_number' => '09261234567',
                'secret_question' => 'What is your favorite food?',
                'secret_answer' => 'Tacos'
            ]);
        }
    }
}
