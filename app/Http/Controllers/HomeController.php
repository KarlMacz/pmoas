<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Auth;
use Validator;

use App\Feedbacks;

class HomeController extends Controller
{
    use Utilities;

    public function test($number) {
        $this->sendSms($number, 'This is a sample message.');

        return view('home.test');
    }
    
    public function index() {
        if(Auth::check()) {
            $this->createLog(Auth::user()->id, 'Success', 'visited ' . url()->current());
        }

        return view('home.index', [
            'feedbacks' => Feedbacks::get()
        ]);
    }

    public function postCreateFeedback(Request $request) {
        if(Auth::check()) {
            $validator = Validator::make($request->all(), [
                'comment' => 'required|string|max:1000',
                'rate' => 'required|numeric|between:1,5',
            ]);

            if($validator->fails()) {
                return redirect('/#comments-and-suggestions-section')->withErrors($validator)
                    ->withInput();
            }

            $result = Feedbacks::create([
                'account_id' => Auth::user()->id,
                'rating' => $request->input('rate'),
                'comment' => $request->input('comment')
            ]);

            if($result->id) {
                $this->createLog(Auth::user()->id, 'Success', 'posted a feedback.');

                session()->flash('flash_status', 'Success');
                session()->flash('flash_message', 'Feedback has been sent.');
            } else {
                session()->flash('flash_status', 'Failed');
                session()->flash('flash_message', 'Failed to send feedback.');
            }

            return redirect('/#comments-and-suggestions-section');
        } else {
            return redirect()->route('auth.get.index');
        }
    }
}
