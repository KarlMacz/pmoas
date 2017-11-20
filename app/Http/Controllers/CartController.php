<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Auth;

use App\Carts;
use App\CartItems;
use App\Products;

class CartController extends Controller
{
    use Utilities;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        $this->createLog(Auth::user()->id, 'Success', 'visited ' . url()->current());

        return view('clients.shopping_cart', [
            'cart' => Carts::where('account_id', Auth::user()->id)->first()
        ]);
    }

    public function postAddItemToCart(Request $request) {
        $product = Products::where('id', $request->input('id'))->first();

        if($product) {
            if($request->input('quantity') >= 1 && $request->input('quantity') <= $product->remaining_quantity) {
                $cart = Carts::where('account_id', Auth::user()->id)->first();

                if(!$cart) {
                    $cart = Carts::create([
                        'account_id' => Auth::user()->id
                    ]);
                }

                $cartItem = CartItems::where('cart_id', $cart->id)->where('product_id', $request->input('id'))->first();

                if(!$cartItem) {
                    $this->createLog(Auth::user()->id, 'Success', 'added ' . $request->input('quantity') . ' piece(s) of ' . $product->name . ' to the shopping cart.');

                    CartItems::create([
                        'cart_id' => $cart->id,
                        'product_id' => $request->input('id'),
                        'quantity' => $request->input('quantity')
                    ]);
                } else {
                    $this->createLog(Auth::user()->id, 'Success', 'changed the quantity of ' . $product->name . ' in the shopping cart to ' . $request->input('quantity') . '.');

                    CartItems::where('cart_id', $cart->id)->where('product_id', $request->input('id'))->update([
                        'quantity' => $request->input('quantity')
                    ]);
                }

                return response()->json([
                    'status' => 'Success',
                    'message' => 'Product has been added to your shopping cart.'
                ]);
            } else {
                return response()->json([
                    'status' => 'Failed',
                    'message' => 'Quantity should be between 1 and ' . $product->remaining_quantity . '.'
                ]);
            }
        } else {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Product doesn\' exist.'
            ]);
        }
    }

    public function postRemoveItemFromCart(Request $request) {
        $cartItem = CartItems::where('id', $request->input('id'))->first();

        if($cartItem) {
            $query = CartItems::where('id', $request->input('id'))->delete();

            if($query) {
                $this->createLog(Auth::user()->id, 'Success', 'removed ' . $cartItem->product->name . ' from the shopping cart.');

                return response()->json([
                    'status' => 'Success',
                    'message' => 'Product has been removed from your shopping cart.'
                ]);
            } else {
                return response()->json([
                    'status' => 'Failed',
                    'message' => 'Failed to remove product from your shopping cart.'
                ]);
            }
        } else {
            return response()->json([
                'status' => 'Success',
                'message' => 'Product has already been removed from your shopping cart.'
            ]);
        }
    }
}
