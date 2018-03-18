<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Cache\RateLimiter;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;

use App\Http\Requests;

use Auth;
use Hash;
use Mail;
use Validator;

use App\Accounts;
use App\Clients;
use App\Passwords;

class AuthenticationController extends Controller
{
    use AuthenticatesUsers, ThrottlesLogins, Utilities;

    protected function hasTooManyLoginAttempts(Request $request) {
        $un = $request->get('username');
        $userAccount = Accounts::where('username', $un)->first();

        if($userAccount) {
            if($userAccount->login_attempts <= 3) {
                $loginDecayMinutes = 1;
            } else if($userAccount->login_attempts > 3 && $userAccount->login_attempts <=6) {
                $loginDecayMinutes = 5;
            } else if($userAccount->login_attempts > 6 && $userAccount->login_attempts <=9) {
                $loginDecayMinutes = 10;
            } else if($userAccount->login_attempts > 9 && $userAccount->login_attempts <=12) {
                $loginDecayMinutes = 30;
            } else if($userAccount->login_attempts > 12 && $userAccount->login_attempts <=15) {
                $loginDecayMinutes = 60;
            } else {
                $loginDecayMinutes = 1440;
            }
        } else {
            $loginDecayMinutes = 0;
        }

        return app(RateLimiter::class)->tooManyAttempts(
            $this->getThrottleKey($request), 3, $loginDecayMinutes
        );
    }

    protected function incrementLoginAttempts(Request $request) {
        $un = $request->get('username');
        Accounts::where('username', $un)->increment('login_attempts');

        app(RateLimiter::class)->hit(
            $this->getThrottleKey($request)
        );
    }

    protected function sendLockoutResponse(Request $request) {
        $seconds = $this->secondsRemainingOnLockout($request);

        session()->flash('flash_status', 'Failed');
        session()->flash('flash_message', $this->getLockoutErrorMessage($seconds));

        return redirect()->back()
            ->withInput($request->only($this->loginUsername(), 'remember'));
    }

    public function login() {
        if(!Auth::check()) {
            return view('auth.login');
        }

        if(Auth::user()->role === 'Employee') {
            return redirect()->route('employees.get.index');
        } else {
            return redirect()->route('clients.get.index');
        }
    }

    public function logout() {
        $this->createLog(Auth::user()->id, 'Success', 'has logged out.');

        Auth::logout();

        return redirect()->route('auth.get.login');
    }

    public function register() {
        return view('auth.register');
    }

    public function forgotPasswordStepOne() {
        return view('auth.forgot_password.step_one');
    }

    public function forgotPasswordStepTwo($username) {
        if($username) {
            $account = Accounts::where('username', $username)->first();

            if($account) {
                return view('auth.forgot_password.step_two', [
                    'account' => $account
                ]);
            } else {
                session()->flash('flash_status', 'Failed');
                session()->flash('flash_message', 'Username doesn\'t exist.');

                return redirect()->route('auth.get.forgot_password_step_one');
            }
        } else {
            session()->flash('flash_status', 'Failed');
            session()->flash('flash_message', 'Please enter your Username.');

            return redirect()->route('auth.get.forgot_password_step_one');
        }
    }

    public function verification($code) {
        $account = Accounts::where('verification_code', $code)->first();

        if($account) {
            if($account->is_verified == false) {
                $query = Accounts::where('id', $account->id)->update([
                    'is_verified' => true,
                    'verification_code' => null
                ]);

                if($query) {
                    session()->flash('flash_status', 'Success');
                    session()->flash('flash_message', 'Account has been verified. You may now log in your account.');
                } else {
                    session()->flash('flash_status', 'Failed');
                    session()->flash('flash_message', 'Failed to verify account.');
                }
            } else {
                session()->flash('flash_status', 'Success');
                session()->flash('flash_message', 'Account has already been verified.');
            }
        } else {
            session()->flash('flash_status', 'Failed');
            session()->flash('flash_message', 'Verification code doesn\'t exist.');
        }

        return redirect()->route('auth.get.login');
    }

    public function postLogin(Request $request) {
        $throttles = $this->isUsingThrottlesLoginsTrait();

        if($throttles && $lockedOut = $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $username = $request->input('username');
        $password = $request->input('password');

        if(Auth::attempt(['username' => $username, 'password' => $password, 'is_verified' => true])) {
            $this->createLog(Auth::user()->id, 'Success', 'has logged in.');

            if(Auth::user()->role === 'Employee') {
                return redirect()->route('employees.get.index');
            } else {
                return redirect()->route('clients.get.index');
            }
        } else {
            $account = Accounts::where('username', $username)->where('is_verified', true)->first();

            if($account && !Hash::check($password, $account->password)) {
                if($throttles && !$lockedOut) {
                    $this->incrementLoginAttempts($request);
                }
            }

            session()->flash('flash_status', 'Failed');
            session()->flash('flash_message', 'Invalid username and/or password.');

            return redirect()->route('auth.get.login');
        }
    }

    public function postRegister(Request $request) {
        $validator = Validator::make($request->all(), [
            'username' => 'required|alpha_num|min:5|max:26|unique:accounts',
            'email' => 'required|string|email|max:255|unique:accounts',
            'password' => 'required|alpha_num|min:5|max:26|confirmed',
            'first_name' => 'required|alpha|max:255',
            'middle_name' => 'alpha|max:255',
            'last_name' => 'required|alpha|max:255',
            'address' => 'required|string|max:255',
            'contact_number' => [
                'required',
                'numeric',
                'regex:/^(09|(\+)?639)[0-9]{9}$/'
            ],
            'birth_date' => [
                'required',
                'date',
                'before:' . date('Y-m-d', strtotime('+1 day', strtotime('-18 years'))),
                'after:' . date('Y-m-d', strtotime('-1 day', strtotime('-60 years')))
            ],
            'gender' => 'required|string|max:255',
            'secret_question' => 'required|string|max:255',
            'secret_answer' => 'required|string|max:255',
            'agreement' => 'accepted',
            'g-recaptcha-response' => 'required|recaptcha'
        ], [
            'birth_date.before' => 'You must be at least 18 years old.',
            'birth_date.after' => 'You must be 60 years old or below.'
        ]);

        if($validator->fails()) {
            return redirect()->route('auth.get.register')
                ->withErrors($validator)
                ->withInput();
        }

        $account = Accounts::create([
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'verification_code' => hash('sha256', date('Y_m_d_His') . hash('sha256', $request->input('username')))
        ]);

        if($account) {
            Passwords::create([
                'identifier' => hash('sha256', $request->input('username')),
                'password' => $request->input('password')
            ]);

            $client = Clients::create([
                'account_id' => $account->id,
                'first_name' => $request->input('first_name'),
                'middle_name' => $request->input('middle_name'),
                'last_name' => $request->input('last_name'),
                'address' => $request->input('address'),
                'contact_number' => $request->input('contact_number'),
                'birth_date' => $request->input('birth_date'),
                'gender' => $request->input('gender'),
                'secret_question' => $request->input('secret_question'),
                'secret_answer' => $request->input('secret_answer')
            ]);

            if($client) {
                $email_address = $request->input('email');
                $full_name = $request->input('first_name') . ' ' . $request->input('last_name');

                Mail::send('emails.account_verification', [
                    'account' => $account
                ], function($message) use ($email_address, $full_name) {
                    $message->to($email_address, $full_name)->subject(config('company.name') . ' Account Verification');
                });

                session()->flash('flash_status', 'Success');
                session()->flash('flash_message', 'Client has been registered. Please check your e-mail address for account verification.');
            } else {
                session()->flash('flash_status', 'Failed');
                session()->flash('flash_message', 'Failed to register client.');
            }
        } else {
            session()->flash('flash_status', 'Failed');
            session()->flash('flash_message', 'Failed to register client.');
        }

        return redirect()->route('auth.get.login');
    }

    public function postForgotPasswordStepOne(Request $request) {
        $validator = Validator::make($request->all(), [
            'username' => 'required|alpha_num|min:5|max:26'
        ]);

        if($validator->fails()) {
            return redirect()->route('auth.get.forgot_password_step_one')
                ->withErrors($validator)
                ->withInput();
        }

        $account = Accounts::where('username', $request->input('username'))->first();

        if($account) {
            return redirect()->route('auth.get.forgot_password_step_two', $request->input('username'));
        } else {
            session()->flash('flash_status', 'Failed');
            session()->flash('flash_message', 'Username doesn\'t exist.');

            return redirect()->route('auth.get.forgot_password_step_one');
        }
    }

    public function postForgotPasswordStepTwo(Request $request) {
        $validator = Validator::make($request->all(), [
            'answer' => 'required|string|max:255'
        ]);

        if($validator->fails()) {
            return redirect()->route('auth.get.forgot_password_step_two')
                ->withErrors($validator)
                ->withInput();
        }

        $account = Accounts::where('username', $request->input('username'))->first();

        if($account) {
            if($account->user_info->secret_answer === $request->input('answer')) {
                $pass = Passwords::where('identifier', hash('sha256', $request->input('username')))->first();

                if($pass) {
                    $email_address = $account->email;
                    $full_name = $account->first_name . ' ' . $account->last_name;

                    Mail::send('emails.forgot_password', [
                        'account' => $account,
                        'password' => $pass->password
                    ], function($message) use ($email_address, $full_name) {
                        $message->to($email_address, $full_name)->subject(config('company.name') . ' Forgot Password');
                    });

                    session()->flash('flash_status', 'Success');
                    session()->flash('flash_message', 'Your account information has been sent to your e-mail address.');
                } else {
                    session()->flash('flash_status', 'Failed');
                    session()->flash('flash_message', 'Failed to send your account information to your e-mail address.');
                }

                return redirect()->route('auth.get.login');
            } else {
                session()->flash('flash_status', 'Failed');
                session()->flash('flash_message', 'Your answer is incorrect.');

                return redirect()->route('auth.get.forgot_password_step_two', $request->input('username'));
            }
        } else {
            session()->flash('flash_status', 'Failed');
            session()->flash('flash_message', 'Username doesn\'t exist.');

            return redirect()->route('auth.get.forgot_password_step_one');
        }
    }
}
