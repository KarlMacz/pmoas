<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Auth;
use Input;

use App\Orders;
use App\Products;
use App\Transactions;

use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Payer;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Details;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;

class PaymentController extends Controller
{
    private $api_context;

    public function __construct() {
        $this->middleware(['auth', 'clients']);

        $this->api_context = new ApiContext(new OAuthTokenCredential(config('paypal.client_id'), config('paypal.secret')));
        $this->api_context->setConfig(config('paypal.settings'));
    }

    public function payPalStatus($tid = '') {
        if($tid !== '') {
            $transaction = Transactions::where('id', $tid)->first();
            
            if($transaction) {
                $trn = Transactions::where('id', $tid)->update([
                    'amount_paid' => $transaction->total_amount
                ]);

                if($trn) {
                    $paymentId = Input::get('paymentId');
                    $payerId = Input::get('PayerID');

                    $payment = Payment::get($paymentId, $this->api_context);

                    $execute = new PaymentExecution();
                    $execute->setPayerId($payerId);

                    try {
                        $result = $payment->execute($execute, $this->api_context);
                    } catch(Exception $ex) {
                        if (config('app.debug')) {
                            echo "Exception: " . $ex->getMessage() . PHP_EOL;

                            exit;
                        } else {
                            die('An error with PayPal occured.');
                        }
                    }

                    if($result->getState() == 'approved') {
                        session()->flash('flash_status', 'Success');
                        session()->flash('flash_message', 'Payment Successful.');
                    } else {
                        session()->flash('flash_status', 'Failed');
                        session()->flash('flash_message', 'Payment failed.');
                    }
                } else {
                    session()->flash('flash_status', 'Failed');
                    session()->flash('flash_message', 'Payment failed.');
                }
            } else {
                session()->flash('flash_status', 'Failed');
                session()->flash('flash_message', 'Transaction doesn\'t exist.');
            }
        } else {
            session()->flash('flash_status', 'Failed');
            session()->flash('flash_message', 'Payment failed.');
        }

        return redirect()->route('clients.get.orders');
    }

    public function postPayPalPayment(Request $request) {
        $id = $request->input('id');
        $trn = Transactions::where('id', $id)->first();

        if($trn) {
            $payer = new Payer();
            $payer->setPaymentMethod('paypal');

            $items = [];
            $totalAmount = 0;

            foreach($trn->orders as $index => $order) {
                $items[$index] = new Item();
                $items[$index]->setName($order->product->name)
                    ->setCurrency('PHP')
                    ->setQuantity($order->quantity)
                    ->setPrice($order->product->price_per_piece);
                $totalAmount += ($order->quantity * $order->product->price_per_piece);
            }

            $itemList = new ItemList();
            $itemList->setItems($items);

            $details = new Details();
            $details->setShipping(0.00)
                ->setSubtotal($totalAmount);

            $amount = new Amount();
            $amount->setCurrency('PHP')
                ->setTotal($totalAmount)
                ->setDetails($details);

            $transaction = new Transaction();
            $transaction->setAmount($amount)
                ->setItemList($itemList)
                ->setDescription('Product Order')
                ->setInvoiceNumber(uniqid());

            $redirectUrls = new RedirectUrls();
            $redirectUrls->setReturnUrl(route('payments.get.paypal_status', $id))
                ->setCancelUrl(route('payments.get.paypal_status'));

            $payment = new Payment();
            $payment->setIntent('Sale')
                ->setPayer($payer)
                ->setRedirectUrls($redirectUrls)
                ->setTransactions([$transaction]);

            try {
                $payment->create($this->api_context);
            } catch(PayPal\Exception\PayPalConnectionException $ex) {
                if (config('app.debug')) {
                    echo "Exception: " . $ex->getMessage() . PHP_EOL;

                    exit;
                } else {
                    die('An error with PayPal occured.');
                }
            }

            return redirect($payment->getApprovalLink());
        } else {
            session()->flash('flash_status', 'Failed');
            session()->flash('flash_message', 'Order doesn\'t exist.');

            return redirect()->route('clients.get.orders');
        }
    }
}
