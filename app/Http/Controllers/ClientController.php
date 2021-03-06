<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Auth;
use Input;
use Storage;
use Validator;

use App\Cancellations;
use App\Carts;
use App\CartItems;
use App\Contracts;
use App\Helps;
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

        return view('clients.index', [
            'transactions' => Transactions::where('account_id', Auth::user()->id)->whereIn('delivery_status', ['Pending', 'Dispatched'])->get()
        ]);
    }

    public function search() {
        $this->createLog(Auth::user()->id, 'Success', 'visited ' . url()->current());

        if(Input::has('search')) {
            $search = Input::get('search');

            return view('clients.search', [
                'products' => Products::where('id', $search)->orWhere('name', 'like', '%' . $search . '%')->get()
            ]);
        } else {
            return redirect()->route('clients.get.index');
        }
    }

    public function help() {
        $this->createLog(Auth::user()->id, 'Success', 'visited ' . url()->current());

        return view('clients.help', [
            'helps' => Helps::where('type', 'Clients')->get()
        ]);
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

    public function returnProducts() {
        $this->createLog(Auth::user()->id, 'Success', 'visited ' . url()->current());

        return view('clients.return_products', [
            'transactions' => Transactions::where('account_id', Auth::user()->id)->where('delivery_status', 'Delivered')->get()
        ]);
    }

    public function returnProductsProcess($id) {
        $this->createLog(Auth::user()->id, 'Success', 'visited ' . url()->current());

        return view('clients.process_return_products', [
            'transaction' => Transactions::where('id', $id)->first()
        ]);
    }

    public function contracts() {
        $this->createLog(Auth::user()->id, 'Success', 'visited ' . url()->current());

        return view('clients.contracts', [
            'contracts' => Contracts::where('contractee_id', Auth::user()->id)->get()
        ]);
    }

    public function viewReceipt($id) {
        $this->createLog(Auth::user()->id, 'Success', 'visited ' . url()->current());

        return response(Storage::disk('receipts')->get('order_receipt_' . sprintf('%010d', $id) . '.pdf'), 200)->header('Content-Type', 'application/pdf');
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
                    $ord = Orders::create([
                        'transaction_id' => $transaction->id,
                        'product_id' => $cartItem->product_id,
                        'quantity' => $cartItem->quantity
                    ]);

                    if($ord) {
                        Products::where('id', $cartItem->product_id)->decrement('remaining_quantity', $cartItem->quantity);
                    }
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

    public function postReturnProductsProcess($id, Request $request) {
        $validator = Validator::make($request->all(), [
            'id.*' => 'required|numeric',
            'quantity.*' => 'required|numeric|min:0'
        ]);

        if($validator->fails()) {
            return redirect()->route('clients.get.products_return', $id)
                ->withErrors($validator)
                ->withInput();
        }

        $totalAmountCancelled = 0;
        $ctr = 0;

        foreach($request->input('id') as $index => $pid) {
            if($request->input('quantity.' . $index) > 0) {
                $product = Products::where('id', $pid)->first();

                $cancellation = Cancellations::create([
                    'transaction_id' => $id,
                    'product_id' => $pid,
                    'quantity' => $request->input('quantity.' . $index)
                ]);

                if($cancellation) {
                    $totalAmountCancelled += ($product->price_per_piece * $request->input('quantity.' . $index));

                    $ctr++;
                }
            }
        }

        if($ctr > 0) {
            Transactions::where('id', $id)->update([
                'total_amount_cancelled' => $totalAmountCancelled
            ]);

            session()->flash('flash_status', 'Success');
            session()->flash('flash_message', 'Return products successful.');

            return redirect()->route('clients.get.products_return');
        } else {
            session()->flash('flash_status', 'Failed');
            session()->flash('flash_message', 'Failed to return products.');

            return redirect()->route('clients.get.products_return_process', $id);
        }
    }
}
