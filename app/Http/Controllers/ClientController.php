<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Products;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'clients']);
    }

    public function index() {
        return view('clients.index');
    }

    public function products() {
        return view('clients.products', [
            'products' => Products::get()
        ]);
    }
}
