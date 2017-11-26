<?php

use Illuminate\Database\Seeder;

use App\Accounts;
use App\Employees;
use App\Passwords;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $account = Accounts::create([
            'username' => 'admin',
            'email' => 'admin.juan@gmail.com',
            'password' => bcrypt('admin'),
            'is_verified' => true,
            'role' => 'Employee'
        ]);

        if($account) {
            Passwords::create([
                'identifier' => hash('sha256', 'admin'),
                'password' => 'admin'
            ]);

            Employees::create([
                'account_id' => $account->id,
                'first_name' => 'Juan',
                'last_name' => 'Dela Cruz',
                'birth_date' => '1995-01-01',
                'address' => '',
                'gender' => 'Male',
                'contact_number' => '09261234567',
                'position' => 'Administrator'
            ]);
        }
    }
}
