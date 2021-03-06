<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Auth;
use File;
use Input;
use Mail;
use PDF;
use Storage;
use Validator;

use App\Accounts;
use App\Clients;
use App\Contracts;
use App\ContractRules;
use App\Documents;
use App\Employees;
use App\Helps;
use App\Jobs;
use App\Logs;
use App\Passwords;
use App\Products;
use App\Stocks;
use App\Suppliers;
use App\Transactions;

class EmployeeController extends Controller
{
    use Receipts, Reports, Utilities;

    public function __construct() {
        $this->middleware(['auth', 'employees']);
    }

    public function index() {
        $this->createLog(Auth::user()->id, 'Success', 'visited ' . url()->current());

        return view('employees.index', [
            'products' => Products::get(),
            'pendingTransactions' => Transactions::where('delivery_status', 'Pending')->get(),
            'dispatchedTransactions' => Transactions::where('delivery_status', 'Dispatched')->get(),
            'logs' => Logs::orderBy('created_at', 'desc')->get()
        ]);
    }

    public function search() {
        $this->createLog(Auth::user()->id, 'Success', 'visited ' . url()->current());

        if(Input::has('search')) {
            $search = Input::get('search');

            return view('employees.search', [
                'transactions' => Transactions::where('id', $search)->get(),
                'products' => Products::where('id', $search)->orWhere('name', 'like', '%' . $search . '%')->get(),
                'employees' => Accounts::join('employees', 'accounts.id', '=', 'employees.account_id')
                    ->where('accounts.id', $search)
                    ->orWhere('accounts.username', $search)
                    ->orWhere('employees.first_name', 'like', '%' . $search . '%')
                    ->orWhere('employees.middle_name', 'like', '%' . $search . '%')
                    ->orWhere('employees.last_name', 'like', '%' . $search . '%')
                ->get()
            ]);
        } else {
            return redirect()->route('employees.get.index');
        }
    }

    public function help() {
        $this->createLog(Auth::user()->id, 'Success', 'visited ' . url()->current());

        return view('employees.help', [
            'employee_helps' => Helps::where('type', 'Employees')->get(),
            'client_helps' => Helps::where('type', 'Clients')->get()
        ]);
    }

    public function addHelp() {
        $this->createLog(Auth::user()->id, 'Success', 'visited ' . url()->current());

        return view('employees.add_help');
    }

    public function products() {
        $this->createLog(Auth::user()->id, 'Success', 'visited ' . url()->current());

        return view('employees.products', [
            'products' => Products::get()
        ]);
    }

    public function addProduct() {
        $this->createLog(Auth::user()->id, 'Success', 'visited ' . url()->current());

        return view('employees.add_products');
    }

    public function editProduct($id) {
        $this->createLog(Auth::user()->id, 'Success', 'visited ' . url()->current());

        return view('employees.edit_products', [
            'product' => Products::where('id', $id)->first()
        ]);
    }

    public function warehouse() {
        $this->createLog(Auth::user()->id, 'Success', 'visited ' . url()->current());

        return view('employees.warehouse', [
            'products' => Products::get()
        ]);
    }

    public function warehouseRestock($id) {
        $this->createLog(Auth::user()->id, 'Success', 'visited ' . url()->current());

        return view('employees.warehouse_restock', [
            'product' => Products::where('id', $id)->first(),
            'suppliers' => Suppliers::get()
        ]);
    }

    public function suppliers() {
        $this->createLog(Auth::user()->id, 'Success', 'visited ' . url()->current());

        return view('employees.suppliers', [
            'suppliers' => Suppliers::get()
        ]);
    }

    public function addSupplier() {
        $this->createLog(Auth::user()->id, 'Success', 'visited ' . url()->current());

        return view('employees.add_suppliers');
    }

    public function editSupplier($id) {
        $this->createLog(Auth::user()->id, 'Success', 'visited ' . url()->current());

        return view('employees.edit_suppliers', [
            'supplier' => Suppliers::where('id', $id)->first()
        ]);
    }

    public function employees() {
        if(Auth::user()->user_info->position !== 'Administrator') {
            return redirect()->route('employees.get.index');
        }

        $this->createLog(Auth::user()->id, 'Success', 'visited ' . url()->current());

        return view('employees.employees', [
            'employees' => Accounts::where('role', 'Employee')->get()
        ]);
    }

    public function registerEmployee() {
        if(Auth::user()->user_info->position !== 'Administrator') {
            return redirect()->route('employees.get.index');
        }

        $this->createLog(Auth::user()->id, 'Success', 'visited ' . url()->current());

        return view('employees.register_employees');
    }

    public function editEmployee($id) {
        if(Auth::user()->user_info->position !== 'Administrator') {
            return redirect()->route('employees.get.index');
        }

        $this->createLog(Auth::user()->id, 'Success', 'visited ' . url()->current());

        return view('employees.edit_employees', [
            'account' => Accounts::where('id', $id)->where('role', 'Employee')->first()
        ]);
    }

    public function clients() {
        $this->createLog(Auth::user()->id, 'Success', 'visited ' . url()->current());

        return view('employees.clients', [
            'clients' => Accounts::where('role', 'Client')->get()
        ]);
    }

    public function registerCompanyClient() {
        $this->createLog(Auth::user()->id, 'Success', 'visited ' . url()->current());

        return view('employees.register_clients');
    }

    public function accountingSales() {
        $this->createLog(Auth::user()->id, 'Success', 'visited ' . url()->current());

        return view('employees.accounting_sales', [
            'transactions' => Transactions::get()
        ]);
    }

    public function accountingExpenses() {
        $this->createLog(Auth::user()->id, 'Success', 'visited ' . url()->current());

        return view('employees.accounting_expenses', [
            'transactions' => Transactions::get()
        ]);
    }

    public function accountingIncome() {
        $this->createLog(Auth::user()->id, 'Success', 'visited ' . url()->current());

        return view('employees.accounting_income', [
            'transactions' => Transactions::get()
        ]);
    }

    public function contracts() {
        $this->createLog(Auth::user()->id, 'Success', 'visited ' . url()->current());

        return view('employees.contracts', [
            'contracts' => Contracts::get()
        ]);
    }

    public function addContract() {
        $this->createLog(Auth::user()->id, 'Success', 'visited ' . url()->current());

        return view('employees.add_contracts', [
            'clients' => Accounts::where('role', 'Client')->get()
        ]);
    }

    public function document($id) {
        $this->createLog(Auth::user()->id, 'Success', 'visited ' . url()->current());

        return view('employees.documents', [
            'contract' => Contracts::where('id', $id)->first(),
            'documents' => Documents::where('contract_id', $id)->get()
        ]);
    }

    public function startGeneratingReport($type) {
        switch($type) {
            case 'sales':
                $this->generateSalesReport('daily');
                $this->generateSalesReport('monthly');
                $this->generateSalesReport('yearly');

                break;
            case 'inventory':
                $this->generateInventoryReport();

                break;
            case 'delivery':
                $this->generateDeliveryReport();

                break;
            case 'supplier':
                $this->generateSupplierReport();
                
                break;
            case 'product_information':
                $this->generateProductInformationReport();

                break;
        }

        $this->createLog(Auth::user()->id, 'Success', 'started generating ' . $type . ' report.');

        return response()->json([
            'status' => 'Success',
            'message' => 'Generator has been executed.'
        ]);
    }

    public function salesReport() {
        if(Auth::user()->user_info->position !== 'Administrator' && Auth::user()->user_info->position !== 'Auditor' && Auth::user()->user_info->position !== 'Employee - Sales Department' && Auth::user()->user_info->position !== 'Accountant') {
            return redirect()->route('employees.get.index');
        }

        $this->createLog(Auth::user()->id, 'Success', 'visited ' . url()->current());
        
        return view('reports.sales_reports', [
            'reports' => Storage::disk('sales_report')->files()
        ]);
    }

    public function inventoryReport() {
        if(Auth::user()->user_info->position !== 'Administrator' && Auth::user()->user_info->position !== 'Auditor' && Auth::user()->user_info->position !== 'Employee - Logistics Department') {
            return redirect()->route('employees.get.index');
        }

        $this->createLog(Auth::user()->id, 'Success', 'visited ' . url()->current());
        
        return view('reports.inventory_reports', [
            'reports' => Storage::disk('inventory_report')->files()
        ]);
    }

    public function deliveryReport() {
        if(Auth::user()->user_info->position !== 'Administrator' && Auth::user()->user_info->position !== 'Auditor' && Auth::user()->user_info->position !== 'Employee - Sales Department' && Auth::user()->user_info->position !== 'Accountant') {
            return redirect()->route('employees.get.index');
        }

        $this->createLog(Auth::user()->id, 'Success', 'visited ' . url()->current());

        return view('reports.delivery_reports', [
            'reports' => Storage::disk('delivery_report')->files()
        ]);
    }

    public function supplierReport() {
        if(Auth::user()->user_info->position !== 'Administrator' && Auth::user()->user_info->position !== 'Auditor' && Auth::user()->user_info->position !== 'Employee - Logistics Department') {
            return redirect()->route('employees.get.index');
        }

        $this->createLog(Auth::user()->id, 'Success', 'visited ' . url()->current());

        return view('reports.supplier_reports', [
            'reports' => Storage::disk('supplier_report')->files()
        ]);
    }

    public function productInformationReport() {
        if(Auth::user()->user_info->position !== 'Administrator' && Auth::user()->user_info->position !== 'Auditor' && Auth::user()->user_info->position !== 'Employee - Logistics Department') {
            return redirect()->route('employees.get.index');
        }

        $this->createLog(Auth::user()->id, 'Success', 'visited ' . url()->current());
        
        return view('reports.product_information_reports', [
            'reports' => Storage::disk('product_information_report')->files()
        ]);
    }

    public function viewReport($type, $file) {
        $this->createLog(Auth::user()->id, 'Success', 'visited ' . url()->current());

        $disk = null;

        switch($type) {
            case 'sales':
                $disk = 'sales_report';
                
                break;
            case 'inventory':
                $disk = 'inventory_report';
                
                break;
            case 'delivery':
                $disk = 'delivery_report';
                
                break;
            case 'supplier':
                $disk = 'supplier_report';
                
                break;
            case 'product_information':
                $disk = 'product_information_report';
                
                break;
        }

        return response(Storage::disk($disk)->get($file), 200)->header('Content-Type', 'application/pdf');
    }

    public function viewReceipt($id) {
        $this->createLog(Auth::user()->id, 'Success', 'visited ' . url()->current());

        return response(Storage::disk('receipts')->get('order_receipt_' . sprintf('%010d', $id) . '.pdf'), 200)->header('Content-Type', 'application/pdf');
    }

    public function orders() {
        $this->createLog(Auth::user()->id, 'Success', 'visited ' . url()->current());

        return view('employees.client_orders', [
            'transactions' => Transactions::get()
        ]);
    }

    public function returnProducts() {
        $this->createLog(Auth::user()->id, 'Success', 'visited ' . url()->current());

        return view('employees.return_products', [
            'transactions' => Transactions::where('delivery_status', 'Delivered')->get()
        ]);
    }

    public function postRegisterCompanyClient(Request $request) {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'middle_name' => 'string|max:255',
            'last_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'contact_number' => [
                'required',
                'numeric',
                'regex:/^(09|(\+)?639)[0-9]{9}$/'
            ],
            'birth_date' => 'required|date',
            'gender' => 'required|string|max:255',
            'company' => 'required|string|max:255'
        ]);

        if($validator->fails()) {
            return redirect()->route('employees.get.company_clients_register')
                ->withErrors($validator)
                ->withInput();
        }

        $username = $this->generateUsername('Client');
        $password = $this->generatePassword();

        $account = Accounts::create([
            'username' => $username,
            'password' => bcrypt($password),
            'is_verified' => true
        ]);

        if($account) {
            Passwords::create([
                'identifier' => hash('sha256', $username),
                'password' => $password
            ]);

            $client = Clients::create([
                'account_id' => $account->id,
                'first_name' => $request->input('first_name'),
                'middle_name' => $request->input('middle_name'),
                'last_name' => $request->input('last_name'),
                'address' => $request->input('address'),
                'contact_number' => $request->input('contact_number'),
                'birth_date' => $request->input('birth_date'),
                'gender' => $request->input('gender'),
                'type' => 'Company Client',
                'company' => $request->input('company')
            ]);

            if($client) {
                $this->createLog(Auth::user()->id, 'Success', 'registered company client ' . $request->input('first_name') . ' ' . $request->input('last_name') . ' to the system.');

                session()->flash('flash_status', 'Success');
                session()->flash('flash_message', 'Company client has been registered.');
            } else {
                session()->flash('flash_status', 'Failed');
                session()->flash('flash_message', 'Failed to register company client.');
            }
        } else {
            session()->flash('flash_status', 'Failed');
            session()->flash('flash_message', 'Failed to register client.');
        }

        return redirect()->route('employees.get.company_clients_register');
    }

    public function postRegisterEmployee(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:accounts',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'string|max:255',
            'last_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'contact_number' => [
                'required',
                'numeric',
                'regex:/^(09|(\+)?639)[0-9]{9}$/'
            ],
            'birth_date' => 'required|date',
            'gender' => 'required|string|max:255',
            'position' =>'required|string|max:255'
        ]);

        if($validator->fails()) {
            return redirect()->route('employees.get.employees_register')
                ->withErrors($validator)
                ->withInput();
        }

        $username = $this->generateUsername('Employee');
        $password = $this->generatePassword();

        $account = Accounts::create([
            'username' => $username,
            'email' => $request->input('email'),
            'password' => bcrypt($password),
            'verification_code' => hash('sha256', date('Y_m_d_His') . hash('sha256', $username)),
            'role' => 'Employee'
        ]);

        if($account) {
            Passwords::create([
                'identifier' => hash('sha256', $username),
                'password' => $password
            ]);

            $employee = Employees::create([
                'account_id' => $account->id,
                'first_name' => $request->input('first_name'),
                'middle_name' => $request->input('middle_name'),
                'last_name' => $request->input('last_name'),
                'address' => $request->input('address'),
                'contact_number' => $request->input('contact_number'),
                'birth_date' => $request->input('birth_date'),
                'gender' => $request->input('gender'),
                'position' => $request->input('position')
            ]);

            if($employee) {
                $email_address = $request->input('email');
                $full_name = $request->input('first_name') . ' ' . $request->input('last_name');

                Mail::send('emails.employee_verification', [
                    'account' => $account,
                    'password' => $password
                ], function($message) use ($email_address, $full_name) {
                    $message->to($email_address, $full_name)->subject(config('company.name') . ' Account Verification');
                });

                $this->createLog(Auth::user()->id, 'Success', 'registered employee ' . $request->input('first_name') . ' ' . $request->input('last_name') . ' to the system.');

                session()->flash('flash_status', 'Success');
                session()->flash('flash_message', 'Employee has been registered. An e-mail has been sent to the employee\' e-mail address for account verification.');
            } else {
                session()->flash('flash_status', 'Failed');
                session()->flash('flash_message', 'Failed to register employee.');
            }
        } else {
            session()->flash('flash_status', 'Failed');
            session()->flash('flash_message', 'Failed to register employee.');
        }

        return redirect()->route('employees.get.employees_register');
    }

    public function postEditEmployee($id, Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'string|max:255',
            'last_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'contact_number' => [
                'required',
                'numeric',
                'regex:/^(09|(\+)?639)[0-9]{9}$/'
            ],
            'birth_date' => 'required|date',
            'gender' => 'required|string|max:255',
            'position' =>'required|string|max:255'
        ]);

        if($validator->fails()) {
            return redirect()->route('employees.get.employees_edit', $id)
                ->withErrors($validator)
                ->withInput();
        }

        $accounts = Accounts::where('email', $request->input('email'))->where('id', '<>', $id)->get();

        if($accounts->count() > 0) {
            $account = Accounts::where('id', $id)->update([
                'email' => $request->input('email')
            ]);

            $employee = Employees::where('id', $id)->update([
                'first_name' => $request->input('first_name'),
                'middle_name' => $request->input('middle_name'),
                'last_name' => $request->input('last_name'),
                'address' => $request->input('address'),
                'contact_number' => $request->input('contact_number'),
                'birth_date' => $request->input('birth_date'),
                'gender' => $request->input('gender'),
                'position' => $request->input('position')
            ]);

            if($account || $employee) {
                $this->createLog(Auth::user()->id, 'Success', 'edited employee ' . $request->input('first_name') . ' ' . $request->input('last_name') . '\'s information.');

                session()->flash('flash_status', 'Success');
                session()->flash('flash_message', 'Employee information has been edited.');
            } else {
                session()->flash('flash_status', 'Failed');
                session()->flash('flash_message', 'Failed to edit employee information.');
            }
        } else {
            session()->flash('flash_status', 'Failed');
            session()->flash('flash_message', 'E-mail address already been used by a client or another employee.');
        }

        return redirect()->route('employees.get.employees_edit', $id);
    }

    public function postDeleteEmployee(Request $request) {
        $employee = Employees::where('account_id', $request->input('id'))->delete();

        if($employee) {
            Accounts::where('id', $request->input('id'))->where('role', 'Employee')->delete();
            return response()->json([
                'status' => 'Success',
                'message' => 'Employee has been deleted.'
            ]);
        } else {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Failed to delete employee.'
            ]);
        }
    }

    public function postAddProduct(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:1',
            'min_pieces' => 'required|numeric|min:1',
            'description' => 'required|string|max:1000',
            'product_image' => 'mimes:jpg,jpeg,png,bmp'
            // 'quantity.*' => 'required|numeric|min:1',
            // 'expiration_date.*' => 'required|date'
        ]);

        if($validator->fails()) {
            return redirect()->route('employees.get.products_add')
                ->withErrors($validator)
                ->withInput();
        }

        $quantity = 0;

        /*foreach($request->input('quantity') as $qty) {
            $quantity += $qty;
        }*/

        if($request->hasFile('product_image')) {
            $image = $request->file('product_image');
            $imageFilename = date('Y_m_d_His') . '_' . $this->generateRandomDigit(5) . '.' . $image->getClientOriginalExtension();
            
            $image->move('uploads', $imageFilename);
        } else {
            $imageFilename = null;
        }

        $product = Products::create([
            'name' => $request->input('name'),
            'price_per_piece' => $request->input('price'),
            'image' => $imageFilename,
            'minimum_pieces_per_bulk' => $request->input('min_pieces'),
            'description' => $request->input('description'),
            'remaining_quantity' => $quantity,
            'quantity_critical_level' => ceil($quantity * 0.25)
        ]);

        if($product) {
            // $id = $product->id;

            /*foreach($request->input('quantity') as $index => $qty) {
                Stocks::create([
                    'product_id' => $id,
                    'quantity' => $qty,
                    'total_amount' => ($qty * $request->input('price')),
                    'expiration_date' => $request->input('expiration_date')[$index]
                ]);
            }*/

            session()->flash('flash_status', 'Success');
            session()->flash('flash_message', 'Product has been added.');
        } else {
            session()->flash('flash_status', 'Failed');
            session()->flash('flash_message', 'Failed to add product.');
        }

        return redirect()->route('employees.get.products_add');
    }

    public function postEditProduct($id, Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:1',
            'min_pieces' => 'required|numeric|min:1',
            'description' => 'required|string|max:1000'
        ]);

        if($validator->fails()) {
            return redirect()->route('employees.get.products_edit', $id)
                ->withErrors($validator)
                ->withInput();
        }

        $product = Products::where('id', $id)->update([
            'name' => $request->input('name'),
            'price_per_piece' => $request->input('price'),
            'minimum_pieces_per_bulk' => $request->input('min_pieces'),
            'description' => $request->input('description')
        ]);

        if($product) {
            session()->flash('flash_status', 'Success');
            session()->flash('flash_message', 'Product has been edited.');
        } else {
            session()->flash('flash_status', 'Failed');
            session()->flash('flash_message', 'Failed to edit product.');
        }

        return redirect()->route('employees.get.products_edit', $id);
    }

    public function postDeleteProduct(Request $request) {
        $stocks = Stocks::where('product_id', $request->input('id'))->delete();
        $product = Products::where('id', $request->input('id'))->delete();

        if($product) {
            return response()->json([
                'status' => 'Success',
                'message' => 'Product has been deleted.'
            ]);
        } else {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Failed to delete product.'
            ]);
        }
    }

    public function postWarehouseRestock($id, Request $request) {
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|numeric|min:1',
            'expiration_date' => 'required|date',
            'supplier' => 'required|numeric|min:1',
        ]);

        if($validator->fails()) {
            return redirect()->route('employees.get.warehouse_restock', $id)
                ->withErrors($validator)
                ->withInput();
        }

        $productInfo = Products::where('id', $id)->first();
        $newQuantity = $productInfo->remaining_quantity + $request->input('quantity');

        $stock = Stocks::create([
            'product_id' => $id,
            'supplier_id' => $request->input('supplier'),
            'quantity' => $request->input('quantity'),
            'expiration_date' => $request->input('expiration_date')
        ]);

        if($stock) {
            $product = Products::where('id', $id)->update([
                'remaining_quantity' => $newQuantity,
                'quantity_critical_level' => ceil($newQuantity * 0.25)
            ]);

            if($product) {
                session()->flash('flash_status', 'Success');
                session()->flash('flash_message', 'Product re-stock successful.');
            } else {
                Stocks::where('id', $stock->id)->delete();

                session()->flash('flash_status', 'Failed');
                session()->flash('flash_message', 'Failed to re-stock product.');
            }
        } else {
            session()->flash('flash_status', 'Failed');
            session()->flash('flash_message', 'Failed to re-stock product.');
        }

        return redirect()->route('employees.get.warehouse_restock', $id);
    }

    public function postAddSupplier(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255'
        ]);

        if($validator->fails()) {
            return redirect()->route('employees.get.suppliers_add', $id)
                ->withErrors($validator)
                ->withInput();
        }

        $supplier = Suppliers::create([
            'name' => $request->input('name')
        ]);

        if($supplier) {
            session()->flash('flash_status', 'Success');
            session()->flash('flash_message', 'Supplier has been added.');
        } else {
            session()->flash('flash_status', 'Failed');
            session()->flash('flash_message', 'Failed to add supplier.');
        }

        return redirect()->route('employees.get.suppliers_add');
    }

    public function postEditSupplier($id, Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255'
        ]);

        if($validator->fails()) {
            return redirect()->route('employees.get.suppliers_edit', $id)
                ->withErrors($validator)
                ->withInput();
        }

        $supplier = Suppliers::where('id', $id)->update([
            'name' => $request->input('name')
        ]);

        if($supplier) {
            session()->flash('flash_status', 'Success');
            session()->flash('flash_message', 'Supplier has been edited.');
        } else {
            session()->flash('flash_status', 'Failed');
            session()->flash('flash_message', 'Failed to edit supplier.');
        }

        return redirect()->route('employees.get.suppliers_edit', $id);
    }

    public function postDeleteSupplier(Request $request) {
        $supplier = Suppliers::where('id', $request->input('id'))->delete();

        if($supplier) {
            return response()->json([
                'status' => 'Success',
                'message' => 'Supplier has been deleted.'
            ]);
        } else {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Failed to delete supplier.'
            ]);
        }
    }

    public function postAddContract(Request $request) {
        $validator = Validator::make($request->all(), [
            'client' => 'required',
            'lifespan_start' => 'required',
            'lifespan_end' => 'required',
            'type' => 'required|string|max:255',
            'structure' => 'required|string|max:1000',
            'rules.*' => 'required|string|max:255'
        ]);

        if($validator->fails()) {
            return redirect()->route('employees.get.add_contracts')
                ->withErrors($validator)
                ->withInput();
        }

        $contract = Contracts::create([
            'contractor_id' => Auth::user()->id,
            'contractee_id' => $request->input('client'),
            'lifespan_start' => $request->input('lifespan_start'),
            'lifespan_end' => $request->input('lifespan_end'),
            'type' => $request->input('type'),
            'structure' => $request->input('structure'),
            'maximum_amount' => $request->input('maximum_amount'),
            'holdback_amount' => $request->input('holdback_amount'),
            'mode_of_payment' => $request->input('payment_mode')
        ]);

        if($contract) {
            $ctr = 0;

            foreach($request->input('rules') as $rule) {
                $contractRule = ContractRules::create([
                    'contract_id' => $contract->id,
                    'rule' => $rule
                ]);

                if($contractRule) {
                    $ctr++;
                }
            }

            if($ctr > 0) {
                session()->flash('flash_status', 'Success');
                session()->flash('flash_message', 'Contract has been created.');
            } else {
                session()->flash('flash_status', 'Failed');
                session()->flash('flash_message', 'Failed to create contract.');
            }
        } else {
            session()->flash('flash_status', 'Failed');
            session()->flash('flash_message', 'Failed to create contract.');
        }

        return redirect()->route('employees.get.contracts_add');
    }

    public function postDeleteContract(Request $request) {
        $documents = Documents::where('contract_id', $request->input('id'))->delete();

        if($documents) {
            $contractRules = ContractRules::where('contract_id', $request->input('id'))->delete();
            
            if($contractRules) {
                $contract = Contracts::where('id', $request->input('id'))->delete();

                if($contract) {
                    return response()->json([
                        'status' => 'Success',
                        'message' => 'Contract has been deleted.'
                    ]);
                } else {
                    return response()->json([
                        'status' => 'Failed',
                        'message' => 'Successfully deleted all documents but failed to delete contract.'
                    ]);
                }
            } else {
                return response()->json([
                    'status' => 'Failed',
                    'message' => 'Successfully deleted all documents but failed to delete contract.'
                ]);
            }
        } else {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Failed to delete contract.'
            ]);
        }
    }

    public function postAddDocument(Request $request) {
        $validator = Validator::make($request->all(), [
            'document' => 'mimes:jpg,jpeg,png,bmp,doc,docx,xls,xlsx,ppt,pptx,pdf'
        ], [
            'document.mimes' => 'The file type must be jpg, jpeg, png, bmp, doc, docx, xls, xlsx, ppt, pptx, pdf.'
        ]);

        if($validator->fails()) {
            return redirect()->route('employees.get.contract_documents')
                ->withErrors($validator)
                ->withInput();
        }

        $id = $request->input('id');

        if($request->hasFile('document')) {
            $document = $request->file('document');
            $documentFilename = date('Y_m_d_His') . '_document_' . $document->getClientOriginalName();

            $query = Documents::create([
                'contract_id' => $id,
                'filename' => $documentFilename
            ]);

            if($query) {
                Storage::disk('document')->put($documentFilename, File::get($document->getRealPath()));
            } else {
                session()->flash('flash_status', 'Failed');
                session()->flash('flash_message', 'Failed to create contract.');
            }
        } else {
            session()->flash('flash_status', 'Failed');
            session()->flash('flash_message', 'Failed to create contract.');
        }

        return redirect()->route('employees.get.contract_documents', $id);
    }

    public function postConfirmOrder(Request $request) {
        $transaction = Transactions::where('id', $request->input('id'))->first();

        if($transaction) {
            $query = Transactions::where('id', $request->input('id'))->update([
                'delivery_status' => 'Dispatched',
                'datetime_delivered' => date('Y-m-d H:i:s')
            ]);

            if($query) {
                // @$this->sendSms($transaction->account->user_info->contact_number, 'Your order from ' . config('company.name') . ' has been dispatched. Transaction ID No. ' . sprintf('%010d', $transaction->id) . '.');
                Jobs::create([
                    'contact_number' => $transaction->account->user_info->contact_number,
                    'message' => 'Your order from ' . config('company.name') . ' has been dispatched. Transaction ID No. ' . sprintf('%010d', $transaction->id) . '.'
                ]);

                @$this->generateReceipt($request->input('id'));

                return response()->json([
                    'status' => 'Success',
                    'message' => 'Transaction has been confirmed.'
                ]);
            } else {
                return response()->json([
                    'status' => 'Failed',
                    'message' => 'Failed to confirm transaction.'
                ]);
            }
        } else {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Transaction doesn\'t exist.'
            ]);
        }
    }

    public function postMarkOrder(Request $request) {
        $transaction = Transactions::where('id', $request->input('id'))->first();

        if($transaction) {
            $query = Transactions::where('id', $request->input('id'))->update([
                'delivery_status' => 'Delivered'
            ]);

            if($query) {
                return response()->json([
                    'status' => 'Success',
                    'message' => 'Transaction has been marked as delivered.'
                ]);
            } else {
                return response()->json([
                    'status' => 'Failed',
                    'message' => 'Failed to mark transaction as delivered.'
                ]);
            }
        } else {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Transaction doesn\'t exist.'
            ]);
        }
    }

    public function postDeleteOrder(Request $request) {
        $transaction = Transactions::where('id', $request->input('id'))->delete();

        if($transaction) {
            return response()->json([
                'status' => 'Success',
                'message' => 'Transaction has been deleted.'
            ]);
        } else {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Failed to delete transaction.'
            ]);
        }
    }

    public function postAddHelp(Request $request) {
        $validator = Validator::make($request->all(), [
            'question' => 'required|string|max:255',
            'answer' => 'required|string|max:1000',
            'type' => 'required|string|max:9'
        ]);

        if($validator->fails()) {
            return redirect()->route('employees.get.add_help')
                ->withErrors($validator)
                ->withInput();
        }

        $help = Helps::create([
            'question' => $request->input('question'),
            'answer' => $request->input('answer'),
            'type' => $request->input('type')
        ]);

        if($help) {
            session()->flash('flash_status', 'Success');
            session()->flash('flash_message', 'FAQ has been added.');
        } else {
            session()->flash('flash_status', 'Failed');
            session()->flash('flash_message', 'Failed to add FAQ.');
        }

        return redirect()->route('employees.get.help_add');
    }

    public function postDeleteHelp(Request $request) {
        $help = Helps::where('id', $request->input('id'))->delete();

        if($help) {
            return response()->json([
                'status' => 'Success',
                'message' => 'FAQ has been deleted.'
            ]);
        } else {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Failed to delete FAQ.'
            ]);
        }
    }
}
