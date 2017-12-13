<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Auth;
use PDF;
use Validator;

use App\Carts;
use App\CartItems;
use App\Contracts;
use App\Logs;
use App\Orders;
use App\Products;
use App\Transactions;

class ClientController extends Controller
{
    use Utilities;

    public function __construct() {
        $this->middleware(['auth', 'clients']);
    }

    public function index() {
        $this->createLog(Auth::user()->id, 'Success', 'visited ' . url()->current());

        return view('clients.index');
    }

    public function help() {
        $this->createLog(Auth::user()->id, 'Success', 'visited ' . url()->current());

        return view('clients.help');
    }

    public function products() {
        $this->createLog(Auth::user()->id, 'Success', 'visited ' . url()->current());

        return view('clients.products', [
            'products' => Products::get()
        ]);
    }

    public function orders() {
        $this->createLog(Auth::user()->id, 'Success', 'visited ' . url()->current());

        return view('clients.orders', [
            'transactions' => Transactions::where('account_id', Auth::user()->id)->get()
        ]);
    }

    public function contracts() {
        $this->createLog(Auth::user()->id, 'Success', 'visited ' . url()->current());

        return view('clients.contracts', [
            'contracts' => Contracts::where('contractee_id', Auth::user()->id)->get()
        ]);
    }

    public function viewContract($code) {
        $contracts = Contracts::get();

        foreach($contracts as $contract) {
            if(hash('sha256', $contract->id) === $code) {
                $data['contract'] = $contract;

                break;
            }
        }

        if($data['contract']) {
            $pdf = PDF::loadView('pdf.contract', $data);

            return $pdf->stream();
        }
    }

    public function postOrder(Request $request) {
        $validator = Validator::make($request->all(), [
            'payment_method' => 'required|string|max:255'
        ]);

        if($validator->fails()) {
            return redirect()->route('cart.get.index')
                ->withErrors($validator)
                ->withInput();
        }

        $cart = Carts::where('account_id', Auth::user()->id)->first();

        if($cart) {
            $cartItems = CartItems::where('cart_id', $cart->id)->get();

            if($cartItems) {
                $totalAmount = 0;

                foreach($cartItems as $ci) {
                    $totalAmount += $ci->quantity * $ci->product->price_per_piece;
                }

                $transaction = Transactions::create([
                    'account_id' => Auth::user()->id,
                    'payment_method' => $request->input('payment_method'),
                    'total_amount' => $totalAmount
                ]);

                foreach($cartItems as $cartItem) {
                    Orders::create([
                        'transaction_id' => $transaction->id,
                        'product_id' => $cartItem->product_id,
                        'quantity' => $cartItem->quantity
                    ]);
                }

                CartItems::where('cart_id', $cart->id)->delete();

                session()->flash('flash_status', 'Success');
                session()->flash('flash_message', 'Your order has been accepted and is now under process.');
            } else {
                session()->flash('flash_status', 'Failed');
                session()->flash('flash_message', 'You cannot order with empty cart.');
            }
        } else {
            session()->flash('flash_status', 'Failed');
            session()->flash('flash_message', 'You cannot order with empty cart.');
        }

        return redirect()->route('cart.get.index');
    }
}
