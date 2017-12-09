<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Hash;
use Storage;

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
}
