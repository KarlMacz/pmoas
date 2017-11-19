<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Hash;

use App\Products;

class ResourceController extends Controller
{
    public function dateTime() {
        return response()->json([
            'date' => date('F d, Y'),
            'time' => date('h:i A')
        ]);
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
