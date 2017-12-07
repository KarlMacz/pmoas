<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Auth;
use File;
use Mail;
use Storage;
use Validator;

use App\Accounts;
use App\Clients;
use App\Contracts;
use App\ContractRules;
use App\Documents;
use App\Employees;
use App\Logs;
use App\Passwords;
use App\Products;
use App\Stocks;

class EmployeeController extends Controller
{
    use Utilities;

    public function __construct()
    {
        $this->middleware(['auth', 'employees']);
    }

    public function index() {
        $this->createLog(Auth::user()->id, 'Success', 'visited ' . url()->current());

        return view('employees.index', [
            'logs' => Logs::orderBy('created_at', 'desc')->get()
        ]);
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

    public function employees() {
        if(Auth::user()->user_info->position !== 'Administrator') {
            return view('employees.get.index');
        }

        $this->createLog(Auth::user()->id, 'Success', 'visited ' . url()->current());

        return view('employees.employees', [
            'employees' => Accounts::where('role', 'Employee')->get()
        ]);
    }

    public function registerEmployee() {
        if(Auth::user()->user_info->position !== 'Administrator') {
            return view('employees.get.index');
        }

        $this->createLog(Auth::user()->id, 'Success', 'visited ' . url()->current());

        return view('employees.register_employees');
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

    public function contracts() {
        return view('employees.contracts', [
            'contracts' => Contracts::get()
        ]);
    }

    public function addContract() {
        return view('employees.add_contracts', [
            'clients' => Accounts::where('role', 'Client')->get()
        ]);
    }

    public function document($id) {
        return view('employees.documents', [
            'contract' => Contracts::where('id', $id)->first(),
            'documents' => Documents::where('contract_id', $id)->get()
        ]);
    }

    public function postRegisterCompanyClient(Request $request) {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'middle_name' => 'string|nullable|max:255',
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
                $this->createLog(Auth::user()->id, 'Success', 'registered ' . $request->input('first_name') . ' ' . $request->input('last_name') . ' to the system.');

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
            'middle_name' => 'string|nullable|max:255',
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

                $this->createLog(Auth::user()->id, 'Success', 'registered ' . $request->input('first_name') . ' ' . $request->input('last_name') . ' to the system.');

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

    public function postAddProduct(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:1',
            'min_pieces' => 'required|numeric|min:1',
            'description' => 'required|string|max:1000',
            'quantity.*' => 'required|numeric|min:1',
            'expiration_date.*' => 'required|date'
        ]);

        if($validator->fails()) {
            return redirect()->route('employees.get.products_edit')
                ->withErrors($validator)
                ->withInput();
        }

        $quantity = 0;

        foreach($request->input('quantity') as $qty) {
            $quantity += $qty;
        }

        $product = Products::create([
            'name' => $request->input('name'),
            'price_per_piece' => $request->input('price'),
            'minimum_pieces_per_bulk' => $request->input('min_pieces'),
            'description' => $request->input('description'),
            'remaining_quantity' => $quantity
        ]);

        if($product) {
            $id = $product->id;

            foreach($request->input('quantity') as $index => $qty) {
                Stocks::create([
                    'product_id' => $id,
                    'quantity' => $qty,
                    'expiration_date' => $request->input('expiration_date')[$index]
                ]);
            }

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
            return redirect()->route('employees.get.products_edit')
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

        if($stocks) {
            $product = Products::where('id', $request->input('id'))->delete();

            if($product) {
                return response()->json([
                    'status' => 'Success',
                    'message' => 'Product has been deleted.'
                ]);
            } else {
                return response()->json([
                    'status' => 'Failed',
                    'message' => 'Successfully deleted all product stocks but failed to delete product information.'
                ]);
            }
        } else {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Failed to delete product.'
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
}
