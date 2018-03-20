<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Auth;
use Hash;
use PDF;
use Storage;

use App\Authorizations;
use App\Contracts;
use App\Jobs;
use App\Products;

class ResourceController extends Controller
{
    public function __construct() {
        $this->middleware('auth', [
            'except' => [
                'dateTime',
                'postAuthorization',
                'postJobs',
                'postUpdateJobStatus'
            ]
        ]);
    }

    public function dateTime() {
        return response()->json([
            'date' => date('F d, Y'),
            'time' => date('h:i A')
        ]);
    }

    public function download($type, $file) {
        if($type === 'document' || $type === 'contract') {
            if(Storage::disk($type)->exists($file)) {
                return response()->download(storage_path('app/' . $type . '/' . $file));
            } else {
                return redirect()->back();
            }
        } else {
            return redirect()->back();
        }
    }

    public function viewContract($code) {
        if(Auth::check()) {
            $contracts = Contracts::get();

            foreach($contracts as $contract) {
                if(hash('sha256', $contract->id) === $code) {
                    $data['contract'] = $contract;

                    break;
                }
            }

            if($data['contract']) {
                $pdf = PDF::loadView('pdf.contract', $data);

                return $pdf->stream('contract_' . hash('sha256', $contract->id) . '.pdf', [
                    'Attachment' => false
                ]);
            }
        } else {
            abort('404');
        }
    }

    public function postProducts() {
        $products = Products::with('stocks')->get();

        if($products) {
            return response()->json([
                'status' => 'Success',
                'message' => $products->count() . ' product found.',
                'data' => $products
            ]);
        } else {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Products not found.'
            ]);
        }
    }

    public function postAuthorization(Request $request) {
        if($request->has('authorization_key')) {
            $authorization = Authorizations::where('authorization_key', $request->input('authorization_key'))->where('status', 'Active')->first();

            if($authorization) {
                return response()->json([
                    'status' => 'Success',
                    'message' => 'Access Granted.',
                    'token' => csrf_token()
                ]);
            } else {
                return response()->json([
                    'status' => 'Failed',
                    'message' => 'Access Denied.'
                ]);
            }
        } else {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Missing authorization key.'
            ]);
        }
    }

    public function postJobs(Request $request) {
        if($request->has('authorization_key')) {
            $authorization = Authorizations::where('authorization_key', $request->input('authorization_key'))->where('status', 'Active')->first();

            if($authorization) {
                $jobs = Jobs::where('status', 'Pending')->get();

                if($jobs) {
                    return response()->json([
                        'status' => 'Success',
                        'message' => $jobs->count() . ' jobs found.',
                        'data' => $jobs
                    ]);
                } else {
                    return response()->json([
                        'status' => 'Failed',
                        'message' => 'Jobs not found.'
                    ]);
                }
            } else {
                return response()->json([
                    'status' => 'Failed',
                    'message' => 'Invalid authorization key.'
                ]);
            }
        } else {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Missing authorization key.'
            ]);
        }
    }

    public function postUpdateJobStatus(Request $request) {
        if($request->has('authorization_key')) {
            $authorization = Authorizations::where('authorization_key', $request->input('authorization_key'))->where('status', 'Active')->first();

            if($authorization) {
                $job = Jobs::where('id', $request->input('id'))->update([
                    'status' => 'Sent'
                ]);

                if($job) {
                    return response()->json([
                        'status' => 'Success',
                        'message' => 'Job has been updated.'
                    ]);
                } else {
                    return response()->json([
                        'status' => 'Failed',
                        'message' => 'Failed to update job.'
                    ]);
                }
            } else {
                return response()->json([
                    'status' => 'Failed',
                    'message' => 'Invalid authorization key.'
                ]);
            }
        } else {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Missing authorization key.'
            ]);
        }
    }
}
