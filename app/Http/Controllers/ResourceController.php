<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Auth;
use Hash;
use PDF;
use Storage;

use App\Contracts;
use App\Products;

class ResourceController extends Controller
{
    public function __construct() {
        $this->middleware('auth', [
            'except' => [
                'dateTime'
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
                'message' => 'No product not found.'
            ]);
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
}
