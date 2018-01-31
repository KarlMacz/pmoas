<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Auth;
use Validator;

use App\Accounts;
use App\Passwords;

class ProfileController extends Controller
{
    use Utilities;

    public function __construct() {
        $this->middleware(['auth']);
    }

    public function index() {
        $account = Accounts::where('username', Auth::user()->username)->first();

        if(Auth::user()->role === 'Employee') {
            return view('profile.employees', [
                'profile' => $account
            ]);
        } else {
            return view('profile.clients', [
                'profile' => $account
            ]);
        }
    }

    public function postUpdateAccount(Request $request) {
        $validator = Validator::make($request->all(), [
            'username' => 'required|alpha_num|min:5|max:26',
            'email' => 'required|string|email|max:255'
        ]);

        if($validator->fails()) {
            return redirect()->route('profile.get.index')
                ->withErrors($validator);
        }

        $id = Auth::user()->id;
        $username = Auth::user()->username;
        $password = Passwords::where('identifier', hash('sha256', $username))->first();

        Auth::logout();

        $account = Accounts::where('id', $id)->update([
            'username' => $request->input('username'),
            'email' => $request->input('email')
        ]);

        if($account) {
            Passwords::where('id', $password->id)->update([
                'identifier' => hash('sha256', $request->input('username'))
            ]);

            Auth::loginUsingId($id);

            session()->flash('flash_status', 'Success');
            session()->flash('flash_message', 'Account Information has been updated.');
        } else {
            session()->flash('flash_status', 'Failed');
            session()->flash('flash_message', 'Failed to update account information.');
        }

        return redirect()->route('profile.get.index');
    }

    public function postUpdatePassword(Request $request) {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required|alpha_num|min:5|max:26',
            'new_password' => 'required|alpha_num|min:5|max:26|confirmed'
        ]);

        if($validator->fails()) {
            return redirect()->route('profile.get.index')
                ->withErrors($validator);
        }

        $id = Auth::user()->id;
        $username = Auth::user()->username;

        Auth::logout();

        $account = Accounts::where('id', $id)->update([
            'password' => bcrypt($request->input('new_password'))
        ]);

        if($account) {
            Passwords::where('identifier', hash('sha256', $username))->update([
                'password' => $request->input('new_password')
            ]);

            Auth::loginUsingId($id);

            session()->flash('flash_status', 'Success');
            session()->flash('flash_message', 'Password has been changed.');
        } else {
            session()->flash('flash_status', 'Failed');
            session()->flash('flash_message', 'Failed to change password.');
        }

        return redirect()->route('profile.get.index');
    }

    public function postUpdateInfo(Request $request) {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|alpha|max:255',
            'middle_name' => 'alpha|max:255',
            'last_name' => [
                'required',
                'string',
                'max:255',
                'regex:/^()$/'
            ],
            'address' => 'required|string|max:255',
            'contact_number' => [
                'required',
                'numeric',
                'regex:/^(09|(\+)?639)[0-9]{9}$/'
            ],
            'birth_date' => 'required|date',
            'gender' => 'required|string|max:255'
        ]);

        if($validator->fails()) {
            return redirect()->route('profile.get.index')
                ->withErrors($validator);
        }

        $id = Auth::user()->id;

        Auth::logout();

        if(Auth::user()->role === 'Employee') {
            $account_info = Employees::where('account_id', $id)->update([
                'first_name' => $request->input('first_name'),
                'middle_name' => $request->input('middle_name'),
                'last_name' => $request->input('last_name'),
                'birth_date' => $request->input('birth_date'),
                'address' => $request->input('address'),
                'gender' => $request->input('gender'),
                'contact_number' => $request->input('contact_number')
            ]);
        } else {
            $account_info = Clients::where('account_id', $id)->update([
                'first_name' => $request->input('first_name'),
                'middle_name' => $request->input('middle_name'),
                'last_name' => $request->input('last_name'),
                'birth_date' => $request->input('birth_date'),
                'address' => $request->input('address'),
                'gender' => $request->input('gender'),
                'contact_number' => $request->input('contact_number')
            ]);
        }

        Auth::loginUsingId($id);

        if($account_info) {
            session()->flash('flash_status', 'Success');
            session()->flash('flash_message', 'Background Information has been updated.');
        } else {
            session()->flash('flash_status', 'Failed');
            session()->flash('flash_message', 'Failed to update background information.');
        }

        return redirect()->route('profile.get.index');
    }
}
