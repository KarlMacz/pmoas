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
        // Administrator
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

        // Auditor
        $account = Accounts::create([
            'username' => 'auditor',
            'email' => 'auditor.migelito@gmail.com',
            'password' => bcrypt('auditor'),
            'is_verified' => true,
            'role' => 'Employee'
        ]);

        if($account) {
            Passwords::create([
                'identifier' => hash('sha256', 'auditor'),
                'password' => 'auditor'
            ]);

            Employees::create([
                'account_id' => $account->id,
                'first_name' => 'Migelito',
                'last_name' => 'Dela Cruz',
                'birth_date' => '1993-01-01',
                'address' => '',
                'gender' => 'Male',
                'contact_number' => '09161234567',
                'position' => 'Auditor'
            ]);
        }

        // Employee - Logistics Department
        $account = Accounts::create([
            'username' => 'logistics',
            'email' => 'logistics.pedro@gmail.com',
            'password' => bcrypt('logistics'),
            'is_verified' => true,
            'role' => 'Employee'
        ]);

        if($account) {
            Passwords::create([
                'identifier' => hash('sha256', 'logistics'),
                'password' => 'logistics'
            ]);

            Employees::create([
                'account_id' => $account->id,
                'first_name' => 'Pedro',
                'last_name' => 'Dela Cruz',
                'birth_date' => '1995-01-01',
                'address' => '',
                'gender' => 'Male',
                'contact_number' => '09261234568',
                'position' => 'Employee - Logistics Department'
            ]);
        }

        // Employee - Sales Department
        $account = Accounts::create([
            'username' => 'sales',
            'email' => 'sales.pepay@gmail.com',
            'password' => bcrypt('sales'),
            'is_verified' => true,
            'role' => 'Employee'
        ]);

        if($account) {
            Passwords::create([
                'identifier' => hash('sha256', 'sales'),
                'password' => 'sales'
            ]);

            Employees::create([
                'account_id' => $account->id,
                'first_name' => 'Pepay',
                'last_name' => 'Dela Cruz',
                'birth_date' => '1994-02-01',
                'address' => '',
                'gender' => 'Female',
                'contact_number' => '09271234568',
                'position' => 'Employee - Sales Department'
            ]);
        }

        // Accountant
        $account = Accounts::create([
            'username' => 'accountant',
            'email' => 'accountant.juana@gmail.com',
            'password' => bcrypt('accountant'),
            'is_verified' => true,
            'role' => 'Employee'
        ]);

        if($account) {
            Passwords::create([
                'identifier' => hash('sha256', 'accountant'),
                'password' => 'accountant'
            ]);

            Employees::create([
                'account_id' => $account->id,
                'first_name' => 'Juana',
                'last_name' => 'Dela Cruz',
                'birth_date' => '1996-01-01',
                'address' => '',
                'gender' => 'Female',
                'contact_number' => '09271234567',
                'position' => 'Accountant'
            ]);
        }
    }
}
