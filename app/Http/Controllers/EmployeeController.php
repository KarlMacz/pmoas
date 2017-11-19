<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Auth;
use Mail;
use Validator;

use App\Accounts;
use App\Clients;
use App\Employees;
use App\Logs;

class EmployeeController extends Controller
{
    use Utilities;

    public function __construct()
    {
        $this->middleware(['auth', 'employees']);
    }

    public function index() {
        return view('employees.index', [
            'logs' => Logs::get()
        ]);
    }

    public function viewEmployees() {
        if(Auth::user()->user_info->position !== 'Administrator') {
            return view('employees.get.index');
        }

        return view('employees.view_employees', [
            'employees' => Accounts::where('role', 'Employee')->get()
        ]);
    }

    public function registerEmployee() {
        if(Auth::user()->user_info->position !== 'Administrator') {
            return view('employees.get.index');
        }

        return view('employees.register_employees');
    }

    public function viewClients() {
        return view('employees.view_clients', [
            'clients' => Accounts::where('role', 'Client')->get()
        ]);
    }

    public function registerCompanyClient() {
        return view('employees.register_clients');
    }

    public function postRegisterCompanyClient(Request $request) {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'middle_name' => 'string|nullable|max:255',
            'last_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'contact_number' => [
                'required',
                'numeric',
                'regex:/^(09|(\+)?639)[0-9]{9}$/'
            ],
            'birth_date' => 'required|date',
            'gender' => 'required|string|max:255',
            'company' => 'required|string|max:255'
        ]);

        if($validator->fails()) {
            return redirect()->route('employees.get.company_clients_register')
                ->withErrors($validator)
                ->withInput();
        }

        $username = $this->generateUsername('Client');
        $password = $this->generatePassword();

        $account = Accounts::create([
            'username' => $username,
            'password' => bcrypt($password),
            'is_verified' => true
        ]);

        if($account) {
            $client = Clients::create([
                'account_id' => $account->id,
                'first_name' => $request->input('first_name'),
                'middle_name' => $request->input('middle_name'),
                'last_name' => $request->input('last_name'),
                'address' => $request->input('address'),
                'contact_number' => $request->input('contact_number'),
                'birth_date' => $request->input('birth_date'),
                'gender' => $request->input('gender'),
                'type' => 'Company Client',
                'company' => $request->input('company')
            ]);

            if($client) {
                session()->flash('flash_status', 'Success');
                session()->flash('flash_message', 'Company client has been registered.');
            } else {
                session()->flash('flash_status', 'Failed');
                session()->flash('flash_message', 'Failed to register company client.');
            }
        } else {
            session()->flash('flash_status', 'Failed');
            session()->flash('flash_message', 'Failed to register client.');
        }

        return redirect()->route('employees.get.company_clients_register');
    }

    public function postRegisterEmployee(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:accounts',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'string|nullable|max:255',
            'last_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'contact_number' => [
                'required',
                'numeric',
                'regex:/^(09|(\+)?639)[0-9]{9}$/'
            ],
            'birth_date' => 'required|date',
            'gender' => 'required|string|max:255',
            'position' =>'required|string|max:255'
        ]);

        if($validator->fails()) {
            return redirect()->route('employees.get.employees_register')
                ->withErrors($validator)
                ->withInput();
        }

        $username = $this->generateUsername('Employee');
        $password = $this->generatePassword();

        $account = Accounts::create([
            'username' => $username,
            'email' => $request->input('email'),
            'password' => bcrypt($password),
            'verification_code' => hash('sha256', date('Y_m_d_His') . hash('sha256', $username)),
            'role' => 'Employee'
        ]);

        if($account) {
            $employee = Employees::create([
                'account_id' => $account->id,
                'first_name' => $request->input('first_name'),
                'middle_name' => $request->input('middle_name'),
                'last_name' => $request->input('last_name'),
                'address' => $request->input('address'),
                'contact_number' => $request->input('contact_number'),
                'birth_date' => $request->input('birth_date'),
                'gender' => $request->input('gender'),
                'position' => $request->input('position')
            ]);

            if($employee) {
                $email_address = $request->input('email');
                $full_name = $request->input('first_name') . ' ' . $request->input('last_name');

                Mail::send('emails.employee_verification', [
                    'account' => $account,
                    'password' => $password
                ], function($message) use ($email_address, $full_name) {
                    $message->to($email_address, $full_name)->subject(config('company.name') . ' Account Verification');
                });

                session()->flash('flash_status', 'Success');
                session()->flash('flash_message', 'Employee has been registered. An e-mail has been sent to the employee\' for account verification.');
            } else {
                session()->flash('flash_status', 'Failed');
                session()->flash('flash_message', 'Failed to register employee.');
            }
        } else {
            session()->flash('flash_status', 'Failed');
            session()->flash('flash_message', 'Failed to register employee.');
        }

        return redirect()->route('employees.get.employees_register');
    }
}
