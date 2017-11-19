<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Feedbacks;

class HomeController extends Controller
{
    public function index() {
        return view('home.index', [
            'feedbacks' => Feedbacks::get()
        ]);
    }

    public function postCreateFeedbacks(Request $request) {
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
                session()->flash('flash_status', 'Success');
                session()->flash('flash_message', 'Feedback has been sent.');
            } else {
                session()->flash('flash_status', 'Failed');
                session()->flash('flash_message', 'Failed to send feedback.');
            }

            return redirect()->route('home.get.index');
        } else {
            return redirect()->route('auth.get.index');
        }
    }
}
