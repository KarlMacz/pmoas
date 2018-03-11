<?php

namespace App\Http\Controllers;

use PDF;
use Storage;

use App\Transactions;

trait Receipts
{
    public function generateReceipt($id) {
        $reportFilename = 'order_receipt_' . sprintf('%010d', $id) . '.pdf';

        // if(!Storage::disk('receipts')->exists($reportFilename)) {
            $transaction = Transactions::where('id', $id)->first();

            $pdf = PDF::loadView('pdf.order_receipts', [
                'transaction' => $transaction
            ]);

            Storage::disk('receipts')->put($reportFilename, $pdf->output());
        // }
    }
}
