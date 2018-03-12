<?php

namespace App\Http\Controllers;

use PDF;
use Storage;

use App\Products;
use App\Suppliers;
use App\Transactions;

trait Reports
{
    public function generateSalesReport($rangeType) {
        $range = null;
        $transactions = null;

        switch($rangeType) {
            case 'daily':
                $range = date('Y_m_d', strtotime('-1 day'));
                $transactions = Transactions::where('created_at', 'like', date('Y-m-d', strtotime('-1 day')))->get();

                break;
            case 'monthly':
                $range = date('Y_m', strtotime('-1 month'));
                $transactions = Transactions::where('created_at', 'like', date('Y-m', strtotime('-1 month')))->get();

                break;
            case 'yearly':
                $range = date('Y', strtotime('-1 year'));
                $transactions = Transactions::where('created_at', 'like', date('Y', strtotime('-1 year')))->get();

                break;
        }

        $reportFilename = $range . '_' . $rangeType . '_sales_report.pdf';
        $pdf = PDF::loadView('pdf.sales_reports', [
            'type' => $rangeType,
            'transactions' => $transactions
        ]);

        Storage::disk('sales_report')->put($reportFilename, $pdf->output());
    }

    public function generateInventoryReport() {
        $range = date('Y_m_d');

        $reportFilename = $range . '_inventory_report.pdf';
        $pdf = PDF::loadView('pdf.inventory_reports', [
            'products' => Products::get()
        ]);

        Storage::disk('inventory_report')->put($reportFilename, $pdf->output());
    }

    public function generateDeliveryReport() {
        $range = date('Y_m_d', strtotime('-1 day'));
        $transactions = Transactions::where('datetime_delivered', 'like', date('Y-m-d', strtotime('-1 day')))->where('delivery_status', 'Delivered')->get();

        $reportFilename = $range . '_delivery_report.pdf';
        $pdf = PDF::loadView('pdf.delivery_reports', [
            'transactions' => $transactions
        ]);

        Storage::disk('delivery_report')->put($reportFilename, $pdf->output());
    }

    public function generateSupplierReport() {
        $range = date('Y_m_d');
        $suppliers = Suppliers::get();

        $reportFilename = $range . '_supplier_report.pdf';
        $pdf = PDF::loadView('pdf.supplier_reports', [
            'suppliers' => $suppliers
        ]);

        Storage::disk('product_information_report')->put($reportFilename, $pdf->output());
    }

    public function generateProductInformationReport() {
        $range = date('Y_m_d');
        $products = Products::get();

        $reportFilename = $range . '_product_information_report.pdf';
        $pdf = PDF::loadView('pdf.product_information_reports', [
            'products' => $products
        ]);

        Storage::disk('product_information_report')->put($reportFilename, $pdf->output());
    }
}
