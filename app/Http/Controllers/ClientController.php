<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Auth;
use PDF;

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

        return view('clients.index', [
            'logs' => Logs::where('account_id', Auth::user()->id)->orderBy('created_at', 'desc')->get()
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

    public function contracts() {
        $this->createLog(Auth::user()->id, 'Success', 'visited ' . url()->current());

        return view('clients.contracts', [
            'contracts' => Contracts::where('contractee_id', Auth::user()->id)->get()
        ]);
    }

    public function viewContracts($code) {
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
}
