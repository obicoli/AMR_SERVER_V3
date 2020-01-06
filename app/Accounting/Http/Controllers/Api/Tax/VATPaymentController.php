<?php

namespace App\Accounting\Http\Controllers\Api\Tax;

// use App\Accounting\Models\Banks\AccountBankAccountType;
// use App\Accounting\Models\Banks\AccountMasterBank;
use App\Accounting\Models\COA\AccountChartAccount;
use App\Accounting\Models\COA\AccountsCoa;
use App\Accounting\Models\COA\AccountsNature;
use App\Accounting\Models\COA\AccountsType;
use App\Accounting\Models\Tax\AccountsVatPayment;
use App\Accounting\Models\Tax\AccountsVatReturn;
use App\Accounting\Models\Voucher\AccountsVoucher;
use App\Accounting\Repositories\AccountingRepository;
use App\Customer\Models\Customer;
use App\Customer\Repositories\CustomerRepository;
use App\Finance\Models\Banks\AccountBankAccountType;
use App\Finance\Models\Banks\AccountMasterBank;
use App\Finance\Models\Banks\AccountsBank;
use App\Finance\Repositories\FinanceRepository;
use App\helpers\HelperFunctions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use App\Http\Controllers\Controller;
use App\Models\Module\Module;
use App\Models\Practice\Practice;
use App\Models\Product\ProductTaxation;
use App\Repositories\Practice\PracticeRepository;
use App\Repositories\Product\ProductReposity;
use App\Supplier\Models\Supplier;
use App\Supplier\Repositories\SupplierRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Finance\Models\Banks\BankTransaction;
use App\Models\Practice\PracticeUser;

class VATPaymentController extends Controller
{
    //
    protected $accountsVatPayment;
    protected $http_response;
    protected $practices;
    protected $helper;
    protected $accountsTaxations;
    protected $suppliers;
    protected $bankAccounts;
    protected $vatReturns;
    protected $bankTransactions;
    protected $accountDoubleEntries;
    protected $company_users;

    public function __construct(AccountsVatPayment $accountsVatPayment)
    {
        $this->accountsVatPayment = new AccountingRepository( $accountsVatPayment );
        $this->http_response = Config::get('response.http');
        $this->practices = new PracticeRepository( new Practice() );
        $this->helper = new HelperFunctions();
        $this->accountsTaxations = new AccountingRepository(new ProductTaxation());
        $this->bankAccounts = new FinanceRepository( new AccountsBank() );
        $this->vatReturns = new AccountingRepository( new AccountsVatReturn() );
        $this->bankTransactions = new FinanceRepository( new BankTransaction() );
        $this->accountDoubleEntries = new AccountingRepository( new AccountsVoucher() );
        $this->company_users = new PracticeRepository(new PracticeUser());
    }

    public function create(Request $request){
        //Log::info($request);
        $http_resp = $this->http_response['200'];
        $rule = [
            'type'=>'required',
            'bank_account_id'=>'required',
            'amount'=>'required',
            'reference_number'=>'required',
            'trans_date'=>'required',
            'notes'=>'required|max:255',
            'vat_return_id'=>'required'
        ];
        $validation = Validator::make($request->all(),$rule,$this->helper->messages());
        if ($validation->fails()){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }

        DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->beginTransaction();
        DB::connection(Module::MYSQL_FINANCE_DB_CONN)->beginTransaction();
        try{

            $user = $request->user();
            $company = $this->practices->find($user->company_id);
            $company_user = $this->company_users->findByUserAndCompany($user,$company);
            $date_format = $company->date_format;
            $as_at = $this->helper->format_lunox_date($request->trans_date);
            $amount = $request->amount;
            $account_type_vat = AccountsCoa::AC_TYPE_VAT;
            $trans_type_vat_payment = AccountsCoa::TRANS_TYPE_VAT_PAYMENT;
            $notes = $request->notes;
            $bank_reference = $request->reference_number;
            $discount = 0;
            $tax_payable_code = AccountsCoa::AC_SALES_SERVICE_TAX_PAYABLE_CODE;
            $company_tax_payable_ac = $company->chart_of_accounts()->where('default_code',$tax_payable_code)->get()->first();

            $bank_account = $this->bankAccounts->findByUuid($request->bank_account_id);
            $bank_ledger_account = $bank_account->ledger_accounts()->get()->first();
            $vatReturn = $this->vatReturns->findByUuid($request->vat_return_id);
            $inputs = $request->all();
            $inputs['vat_return_id'] = $vatReturn->id;
            $inputs['bank_account_id'] = $bank_account->id;
            $inputs['vat_return_id'] = $vatReturn->id;
            $inputs['trans_date'] = $as_at;
            $new_vat_payment = $this->accountsVatPayment->create($inputs);
            $ledger_support_document = $new_vat_payment->double_entry_support_document()->create(['trans_type'=>$trans_type_vat_payment]);

            $transactions['bank_account_id'] = $bank_account->id;
            $transactions['transaction_date'] = $as_at;
            $transactions['spent'] = $amount;
            $transactions['type'] = $account_type_vat;
            $transactions['name'] = $trans_type_vat_payment;
            $transactions['payee'] = $company->name;
            $transactions['description'] = $notes;
            $transactions['reference'] = $bank_reference;
            $transactions['discount'] = $discount;
            $transactions['comment'] = $notes;
            $bank_transaction = $new_vat_payment->bank_transactions()->create($transactions);//Create and Link this transaction to Supplier Payments
            $bank_transaction = $company->bank_transactions()->save($bank_transaction);//Link transaction to a company
            $bank_account_reconciliation = $this->bankTransactions->getOrCreateBankReconciliation($bank_account,$as_at,null);
            $this->bankTransactions->reconcile_bank_transaction($company_user,$bank_account_reconciliation,$bank_transaction,$bank_account,null,AccountsCoa::RECONCILIATION_NOT_TICKED);
            //Accounting for VAT Payment

            $debited_ac = $company_tax_payable_ac->code;
            $credited_ac = $bank_ledger_account->code;
            //$amount = $tax_value_array[$tz];
            $trans_name = $notes;
            $transaction_id = $this->helper->getToken(10,'VPAY');
            $tax_double_entry = $this->accountDoubleEntries->accounts_double_entry($company,$debited_ac,$credited_ac,$amount,$as_at,$trans_name,$transaction_id);
            $tax_support = $tax_double_entry->supports()->save($ledger_support_document);

        }catch(\Exception $e){
            Log::info($e);
            $http_resp = $this->http_response['500'];
            DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
            DB::connection(Module::MYSQL_FINANCE_DB_CONN)->rollBack();
            return response()->json($http_resp,500);
        }
        DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->commit();
        DB::connection(Module::MYSQL_FINANCE_DB_CONN)->commit();
        return response()->json($http_resp);
    }

}
