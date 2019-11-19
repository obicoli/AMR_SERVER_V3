<?php

namespace App\Accounting\Models\COA;

use App\Finance\Models\Banks\AccountsBank;
use App\Models\Module\Module;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\UuidTrait;
use ByTestGear\Accountable\Traits\Accountable;
use Illuminate\Support\Facades\Log;

class AccountsCoa extends Model
{
    use SoftDeletes,UuidTrait,Accountable;

    const BALANCE_DEBIT = "Debit";
    const BALANCE_CREDIT = "Credit";

    const ASSETS = "Assets";
    const LIABILITY = "Liability";
    const EQUITY = "Equity";
    const EXPENSE = "Expense";
    const REVENUE = "Revenue";

    /*
        WARNING! DO NOT EDIT/CHANGE THE ACCOUNT CODE CONSTANTS LISTED BELOW
    */
    const AC_BANK_CODE = 201; //DO NOT EDIT OR CHANGE
    const AC_INVENTORY_CODE = 107; //DO NOT EDIT OR CHANGE
    const AC_PAYABLE_CODE = 301; //DO NOT EDIT OR CHANGE
    const AC_DISCOUNT_RECEIVED_REFUND_CODE = 901; //DO NOT EDIT OR CHANGE
    const AC_RECEIVABLE_CODE = 102; //DO NOT EDIT OR CHANGE
    const AC_SALES_CODE = 906; //DO NOT EDIT OR CHANGE
    const AC_COST_OF_SALES_CODE = 1004; //DO NOT EDIT OR CHANGE
    const AC_OPENING_BALANCE_EQUITY_CODE = 604; //DO NOT EDIT OR CHANGE
    const AC_OTHER_EXPENSE = 1204; //DO NOT EDIT OR CHANGE
    /*
        WARNING! DO NOT EDIT/CHANGE THE ACCOUNT CODE CONSTANTS LISTED ABOVE
    */

    const AC_TYPE_CUSTOMER = "Customer";
    const AC_TYPE_ACCOUNT = "Account";
    const AC_TYPE_SUPPLIER = "Supplier";
    const AC_TYPE_TRANSFER = "Transfer";
    const AC_TYPE_VAT = "VAT";



    const COST_OF_GOODS = "Cost of goods";
    const SALARY = "Salary";
    const CASH = "Cash";

    const AC_CAPITAL_CODE = 301;
    const AC_OPENING_BALANCE_EQUITY = "Opening Balance Equity";
    const AC_RECEIVABLE = "Accounts Receivable(AR)";
    const AC_PAYABLE = "Accounts Payable(AP)";

    const TRANS_TYPE_DEPOSIT = "Deposit";
    const TRANS_TYPE_INVOICE = "Invoice";
    const TRANS_TYPE_BILL = "Bill";
    const TRANS_TYPE_DISCOUNT_RECEIVED = "Discount Received";
    const TRANS_TYPE_DISCOUNT_ALLOWED = "Discount Allowed";
    const TRANS_TYPE_SUPPLIER_PAYMENT = "Supplier Payment";
    const TRANS_TYPE_CUSTOMER_RECEIPT = "Customer Receipt";
    const TRANS_TYPE_OPENING_BALANCE = "Opening Balance";

    const TRANS_NAME_OPEN_BALANCE = "Opening Balance";
    const TRANS_NAME_JOURNAL_ENTRY = "Journal Entry";
    const TRANS_TYPE_START = "START";

    const TRANS_ID_LENGTH = 10;

    const TRANS_NAME_INVENTORY_OP_STOCK = "Inventory Starting Value";

    protected $connection = Module::MYSQL_ACCOUNTING_DB_CONN;

    protected $table = "accounts_coas";
    protected $fillable = [
        'name',
        'sys_default',
        'accounts_type_id',
        'is_special',
        'code'
    ];
    public function owning(){ return $this->morphTo();} //Branch level
    public function chart_of_accounts(){ return $this->hasMany(AccountChartAccount::class,'default_coa_id'); }
    public function account_types(){ return $this->belongsTo(AccountsType::class,'accounts_type_id'); }
    public function accounts_natures(){ return $this->belongsTo(AccountsNature::class,'accounts_nature_id'); }

    public function bank_accounts(){ return $this->hasMany(AccountsBank::class,'ledger_account_id','id'); }

}
