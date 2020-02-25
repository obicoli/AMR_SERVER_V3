<?php

namespace App\Accounting\Repositories;

use App\Accounting\Models\Banks\AccountMasterBank;
use App\Accounting\Models\Banks\AccountMasterBankBranch;
use App\Accounting\Models\Banks\AccountsBank;
use App\Accounting\Models\COA\AccountChartAccount;
use App\Accounting\Models\COA\AccountsCoa;
use App\Accounting\Models\COA\AccountsHolder;
use App\Accounting\Models\COA\AccountsNature;
use App\Accounting\Models\COA\AccountsType;
use App\Accounting\Models\Payments\AccountPaymentType;
use App\Accounting\Models\Tax\AccountsVatReturn;
use App\Accounting\Models\Voucher\AccountsSupport;
use App\Accounting\Models\Voucher\AccountsVoucher;
use App\Models\Practice\Practice;
use App\Models\Product\ProductTaxation;
use Illuminate\Database\Eloquent\Model;

interface AccountingRepositoryInterface
{
    public function all($paginate=0);
    public function find($id);
    public function findByUuid($uuid);
    public function getByUuid($uuid);
    public function findByCode($code);
    public function findByVATPin($pin);
    public function findByName($name);
    public function findByDefaultCode($code);
    public function findCompanyMainCoaByDefaultCode(Practice $practice, $default_code);
    public function create($inputs = []);
    public function create_chart_of_account(Practice $company, AccountsCoa $accountsCoa, $inputs, Model $account_owner);
    public function create_sub_chart_of_account(Practice $company, AccountChartAccount $mainAccount, $inputs=[], Model $account_owner=null);
    //public function getDefaultCoa();
    public function account_statement(Model $company, AccountsHolder $accountsHolder);
    public function get_account_balances(AccountChartAccount $accountChartAccount, $filters=[] );
    public function getAccountTotalTransactions( AccountChartAccount $accountChartAccount, $filters=[] );
    public function calculate_account_balance(AccountChartAccount $accountChartAccount,$filters=[]);
    // public function transform_bank(AccountMasterBank $accountMasterBank);
    // public function transform_bank_accounts(AccountsBank $accountsBank);
    // public function transform_bank_branch( AccountMasterBankBranch $accountMasterBankBranch );
    public function transform_tax_return(AccountsVatReturn $accountsVatReturn);
    public function transform_vat_type(ProductTaxation $productTaxation);
    public function transform_payment_type(AccountPaymentType $accountPaymentType);
    public function transform_company_chart_of_account(AccountChartAccount $accountChartAccount, $filters=[]);
    public function transform_account_type(AccountsType $accountsType);
    public function transform_account_nature(AccountsNature $accountsNature);
    public function transform_default_coa(AccountsCoa $accountsCoa);
    //public function transform_support_document(AccountsSupport $accountsSupport,Model $company=null);
    public function transform_support_document(AccountsSupport $accountsSupport, Model $company = null);
    public function accounts_double_entry(Model $company ,$debited_code,$credited_code,$amount,$trans_date,$notes,$transaction_id);
    public function create_journal_report(AccountsVoucher $accountsVoucher);
    public function create_general_ledger(Model $company);
    public function create_trail_balance(Model $company,$filters=[]);
    public function retainedEarnings(Model $company, $filters=[]);
    public function netIncome(Model $company, $filters=[]);
    public function create_balance_sheet(Model $company, $filters=[]);
    public function transform_journal_entry(AccountsVoucher $accountsVoucher, $journal_type=AccountsCoa::BALANCE_DEBIT,Model $company=null);
    public function setCompanyChartOfAccount(Model $company);
    public function company_payment_initialization(Model $company);
}