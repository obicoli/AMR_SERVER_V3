<?php

use App\Finance\Models\Banks\AccountBankAccountType;
use App\Accounting\Models\COA\AccountsType;
use Illuminate\Database\Seeder;
use App\Finance\Models\Banks\AccountMasterBank;
use App\Accounting\Models\COA\AccountsCoa;
use App\Accounting\Models\COA\AccountsNature;
use App\Accounting\Models\COA\AccountsNatureType;
use App\Accounting\Repositories\AccountingRepository;
use App\helpers\HelperFunctions;
use App\Models\Practice\Practice;
use App\Models\Hospital\Hospital;
use App\Models\Product\ProductTaxation;

// use App\Models\Account\Banks\AccountsBank;
// use App\Models\Account\Banks\AccountsBankBranch;
// use App\Models\Practice\Accounting\PracticeBank;

class AccountingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Government Tax Rates
        $compana = Practice::find(1);
        $parent_owner = $compana->owner()->get()->first();
        
        $manual_vat = $parent_owner->product_taxations()->create(['name'=>'General Rated','agent_name'=>'KRA','category'=>'VAT','purchase_rate'=>16,'sales_rate'=>16,'registration_number'=>'P051420000J']);
        $capital_goods = $parent_owner->product_taxations()->create(['name'=>'Other Rates','agent_name'=>'KRA','category'=>'VAT','purchase_rate'=>8,'sales_rate'=>8,'registration_number'=>'P051420000J']);
        $zero_rated = $parent_owner->product_taxations()->create(['name'=>'Zero Rated','agent_name'=>'KRA','category'=>'VAT','purchase_rate'=>0,'sales_rate'=>0,'registration_number'=>'P051420000J']);
        $exept = $parent_owner->product_taxations()->create(['name'=>'Exempt','agent_name'=>'KRA','category'=>'VAT','purchase_rate'=>0,'sales_rate'=>0,'registration_number'=>'P051420000J']);

        $manual_vat = $parent_owner->accounts_taxations()->create(['name'=>'General Rated','agent_name'=>'KRA','category'=>'VAT','purchase_rate'=>16,'sales_rate'=>16,'registration_number'=>'P051420000J']);
        $capital_goods = $parent_owner->accounts_taxations()->create(['name'=>'Other Rates','agent_name'=>'KRA','category'=>'VAT','purchase_rate'=>8,'sales_rate'=>8,'registration_number'=>'P051420000J']);
        $zero_rated = $parent_owner->accounts_taxations()->create(['name'=>'Zero Rated','agent_name'=>'KRA','category'=>'VAT','purchase_rate'=>0,'sales_rate'=>0,'registration_number'=>'P051420000J']);
        $exept = $parent_owner->accounts_taxations()->create(['name'=>'Exempt','agent_name'=>'KRA','category'=>'VAT','purchase_rate'=>0,'sales_rate'=>0,'registration_number'=>'P051420000J']);

        // $manual_vat = $parent_owner->product_taxations()->create(['name'=>'KRA-Free','agent_name'=>'KRA','purchase_rate'=>0,'sales_rate'=>0,'description'=>'Capital Acquisitions - KRA-Free']);
        // $capital_goods = $parent_owner->product_taxations()->create(['name'=>'KRA','agent_name'=>'KRA','purchase_rate'=>16,'sales_rate'=>16,'description'=>'Capital Acquisitions - KRA']);
        // $zero_rated = $parent_owner->product_taxations()->create(['name'=>'Capital Acquisitions','agent_name'=>'KRA','purchase_rate'=>0,'sales_rate'=>0,'description'=>'Capital Acquisitions - For making Input Taxed Supplies']);
        // $exept = $parent_owner->product_taxations()->create(['name'=>'KRA-Free Exports','agent_name'=>'KRA','purchase_rate'=>0,'sales_rate'=>0,'description'=>'KRA-Free Exports']);
        // $standard_rated = $parent_owner->product_taxations()->create(['name'=>'KRA-Free Supplies','agent_name'=>'KRA','purchase_rate'=>0,'sales_rate'=>0,'description'=>'KRA-Free Supplies']);
        // $standard_rated = $parent_owner->product_taxations()->create(['name'=>'KRA','agent_name'=>'KRA','purchase_rate'=>10,'sales_rate'=>10,'description'=>'KRA']);
        // $standard_rated = $parent_owner->product_taxations()->create(['name'=>'Non-Capital-KRA-Free','agent_name'=>'KRA','purchase_rate'=>0,'sales_rate'=>0,'description'=>'Non-Capital Acquisitions - KRA-Free']);
        // $standard_rated = $parent_owner->product_taxations()->create(['name'=>'Non-Capital-KRA','agent_name'=>'KRA','purchase_rate'=>10,'sales_rate'=>10,'description'=>'Non-Capital Acquisitions - KRA']);
        // $standard_rated = $parent_owner->product_taxations()->create(['name'=>'Non-Capital Acquisitions','agent_name'=>'KRA','purchase_rate'=>15,'sales_rate'=>15,'description'=>'Non-Capital Acquisitions - For making Input Taxed Supplies (0.0%)']);

        // $parent_owner->product_taxations()->save($manual_vat);
        // $parent_owner->product_taxations()->save($capital_goods);
        // $parent_owner->product_taxations()->save($zero_rated);
        // $parent_owner->product_taxations()->save($exept);
        // $parent_owner->product_taxations()->save($standard_rated);
        //Banking
        //Account type
        AccountBankAccountType::create(['name'=>'Credit']);
        AccountBankAccountType::create(['name'=>'Cheque']);
        AccountBankAccountType::create(['name'=>'Savings']);
        AccountBankAccountType::create(['name'=>'Trust']);
        //Banks
        $kcb = AccountMasterBank::create(['name'=>'KCB','description'=>'Kenya Commercial Bank(KCB)']);
        $coop = AccountMasterBank::create(['name'=>'Cooperative','description'=>'Cooperative Bank']);
        $barc = AccountMasterBank::create(['name'=>'Barclays','description'=>'Barclays Bank']);
        //Branches
        $kcb_moi = $kcb->branches()->create(['name'=>'Moi Avenue','code'=>'017']);
        $barc_kericho = $barc->branches()->create(['name'=>'KERICHO','code'=>'03007']);
        $barc_waiyaki = $barc->branches()->create(['name'=>'WAIYAKI WAY','code'=>'03020']);
        $coop_kenyata_ave = $coop->branches()->create(['name'=>'KENYATTA AVENUE','code'=>'11054']);
        $helper = new HelperFunctions();
        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        $asset = AccountsNature::create(['name'=>'Assets']);
        $liability = AccountsNature::create(['name'=>'Liability']);
        $equity = AccountsNature::create(['name'=>'Equity']);
        $expense = AccountsNature::create(['name'=>'Expense']);
        $revenue = AccountsNature::create(['name'=>'Revenue']);
        //+++++++++++++++++++++++++++++++++++++++++++++
        $type = AccountsNatureType::create(['name'=>'Current']);
        $non_type = AccountsNatureType::create(['name'=>'Non-current']);
        //+++++++++++++++++++++++++++++++++++++++++++++++
        //AccountTypes: Current Assets
        $account_receivable = AccountsType::create(['name'=>'Accounts Receivable(A/R)','accounts_nature_id'=>1,'accounts_nature_type_id'=>$type->id]);
        $ac_current_asset = AccountsType::create(['name'=>'Current assets','accounts_nature_id'=>1,'accounts_nature_type_id'=>$type->id]);
        $cash_and_equivalent = AccountsType::create(['name'=>'Cash and Cash Equivalent','accounts_nature_id'=>1,'accounts_nature_type_id'=>$type->id]);
        //AccountTypes: NON-Current Assets
        $non_current_asset = AccountsType::create(['name'=>'Non-current assets','accounts_nature_id'=>1,'accounts_nature_type_id'=>$non_type->id]);
        $fixed_assets = AccountsType::create(['name'=>'Fixed assets','accounts_nature_id'=>1,'accounts_nature_type_id'=>$non_type->id]);
        //AccountTypes: Current Liability
        $ac_payable = AccountsType::create(['name'=>'Accounts Payable (A/P)','accounts_nature_id'=>2,'accounts_nature_type_id'=>$type->id]);
        $current_liability = AccountsType::create(['name'=>'Current liability','accounts_nature_id'=>2,'accounts_nature_type_id'=>$type->id]);
        $credit_card = AccountsType::create(['name'=>'Credit Card','accounts_nature_id'=>2,'accounts_nature_type_id'=>$type->id]);
        //AccountTypes: NON-Current Liability
        $non_current_liability = AccountsType::create(['name'=>'Non-current liabilities','accounts_nature_id'=>2,'accounts_nature_type_id'=>$non_type->id]);
        //AccountTypes: Equity
        $owner_equity = AccountsType::create(['name'=>"Owner's equity",'accounts_nature_id'=>3]);
        //AccountTypes:Income
        $income = $revenue->account_types()->create(['name'=>"Income"]);
        $other_income = $revenue->account_types()->create(['name'=>"Other income"]);
        // $income = AccountsType::create(['name'=>"Income",'accounts_nature_id'=>5]);
        //$expenses = AccountsType::create(['name'=>"Expenses",'accounts_nature_id'=>4]);
        //AccountTypes: Expense
        $cost_of_sale = $expense->account_types()->create(['name'=>"Cost of sales"]);
        $expenses = $expense->account_types()->create(['name'=>"Expenses"]);
        $other_expense = $expense->account_types()->create(['name'=>"Other expense"]);
        
        //Chart of Accounts Started
        //1. CURRENT ASSETS ACCOUNTS==============
        $account_receivable->default_accounts()->create(['code'=>102,'sys_default'=>true,'name'=>'Accounts Receivable(A/R)','notes'=>""]);
        $ac_current_asset->default_accounts()->create(['code'=>103,'sys_default'=>true,'name'=>"Allowance for bad debts",'notes'=>""]);
        $ac_current_asset->default_accounts()->create(['code'=>104,'sys_default'=>true,'name'=>"Assets available for sale",'notes'=>""]);
        $ac_current_asset->default_accounts()->create(['code'=>105,'sys_default'=>true,'name'=>"Development Costs",'notes'=>""]);
        $ac_current_asset->default_accounts()->create(['code'=>106,'sys_default'=>true,'name'=>"Employee Cash Advances",'notes'=>""]);
        $ac_current_asset->default_accounts()->create(['code'=>107,'sys_default'=>true,'name'=>"Purchase",'notes'=>""]);
        $ac_current_asset->default_accounts()->create(['code'=>108,'sys_default'=>true,'name'=>"Investments - Other",'notes'=>""]);
        $ac_current_asset->default_accounts()->create(['code'=>109,'sys_default'=>true,'name'=>"Loans To Officers",'notes'=>""]);
        $ac_current_asset->default_accounts()->create(['code'=>110,'sys_default'=>true,'name'=>"Loans To Others",'notes'=>""]);
        $ac_current_asset->default_accounts()->create(['code'=>111,'sys_default'=>true,'name'=>"Loans to Shareholders",'notes'=>""]);
        $ac_current_asset->default_accounts()->create(['code'=>112,'sys_default'=>true,'name'=>"Other current assets",'notes'=>""]);
        $ac_current_asset->default_accounts()->create(['code'=>113,'sys_default'=>true,'name'=>"Prepaid Expenses",'notes'=>""]);
        $ac_current_asset->default_accounts()->create(['code'=>114,'sys_default'=>true,'name'=>"Retainage",'notes'=>""]);
        $ac_current_asset->default_accounts()->create(['code'=>115,'sys_default'=>true,'name'=>"Undeposited Funds",'notes'=>""]);
        //2. CASH & CASH EQUIVALENTS=====================
        $cash_and_equivalent->default_accounts()->create(['code'=>201,'sys_default'=>true,'name'=>"Bank",'notes'=>""]);
        $cash_and_equivalent->default_accounts()->create(['code'=>202,'sys_default'=>true,'name'=>"Cash and cash equivalents",'notes'=>""]);
        $cash_and_equivalent->default_accounts()->create(['code'=>203,'sys_default'=>true,'name'=>"Petty Cash",'notes'=>""]);
        $cash_and_equivalent->default_accounts()->create(['code'=>204,'sys_default'=>true,'name'=>"Client trust account",'notes'=>" for money held by you for the benefit of someone else. "]);
        $cash_and_equivalent->default_accounts()->create(['code'=>205,'sys_default'=>true,'name'=>"Money Market",'notes'=>""]);
        $cash_and_equivalent->default_accounts()->create(['code'=>206,'sys_default'=>true,'name'=>"Rents Held in Trust",'notes'=>""]);
        $cash_and_equivalent->default_accounts()->create(['code'=>207,'sys_default'=>true,'name'=>"Savings",'notes'=>""]);
        //3. Fixed assets
        $fixed_assets->default_accounts()->create(['code'=>701,'sys_default'=>true,'name'=>"Accumulated depletion",'notes'=>""]);
        $fixed_assets->default_accounts()->create(['code'=>702,'sys_default'=>true,'name'=>"Accumulated depreciation on property, plant and equipment",'notes'=>""]);
        $fixed_assets->default_accounts()->create(['code'=>703,'sys_default'=>true,'name'=>"Buildings",'notes'=>""]);
        $fixed_assets->default_accounts()->create(['code'=>704,'sys_default'=>true,'name'=>"Depletable Assets",'notes'=>""]);
        $fixed_assets->default_accounts()->create(['code'=>705,'sys_default'=>true,'name'=>"Furniture and Fixtures",'notes'=>""]);
        $fixed_assets->default_accounts()->create(['code'=>706,'sys_default'=>true,'name'=>"Land",'notes'=>""]);
        $fixed_assets->default_accounts()->create(['code'=>707,'sys_default'=>true,'name'=>"Leasehold Improvements",'notes'=>""]);
        $fixed_assets->default_accounts()->create(['code'=>708,'sys_default'=>true,'name'=>"Machinery and equipment",'notes'=>""]);
        $fixed_assets->default_accounts()->create(['code'=>709,'sys_default'=>true,'name'=>"Other fixed assets",'notes'=>""]);
        $fixed_assets->default_accounts()->create(['code'=>710,'sys_default'=>true,'name'=>"Vehicles",'notes'=>""]);
        //4. Non Current Assets
        $non_current_asset->default_accounts()->create(['code'=>801,'sys_default'=>true,'name'=>"Accumulated amortisation of non-current assets",'notes'=>""]);
        $non_current_asset->default_accounts()->create(['code'=>802,'sys_default'=>true,'name'=>"Assets held for sale",'notes'=>""]);
        $non_current_asset->default_accounts()->create(['code'=>803,'sys_default'=>true,'name'=>"Deferred tax",'notes'=>""]);
        $non_current_asset->default_accounts()->create(['code'=>804,'sys_default'=>true,'name'=>"Goodwill",'notes'=>""]);
        $non_current_asset->default_accounts()->create(['code'=>805,'sys_default'=>true,'name'=>"Intangible Assets",'notes'=>""]);
        $non_current_asset->default_accounts()->create(['code'=>806,'sys_default'=>true,'name'=>"Lease Buyout",'notes'=>""]);
        $non_current_asset->default_accounts()->create(['code'=>807,'sys_default'=>true,'name'=>"Licences",'notes'=>""]);
        $non_current_asset->default_accounts()->create(['code'=>808,'sys_default'=>true,'name'=>"Long-term investments",'notes'=>""]);
        $non_current_asset->default_accounts()->create(['code'=>809,'sys_default'=>true,'name'=>"Organisational Costs",'notes'=>""]);
        $non_current_asset->default_accounts()->create(['code'=>810,'sys_default'=>true,'name'=>"Other non-current assets",'notes'=>""]);
        $non_current_asset->default_accounts()->create(['code'=>811,'sys_default'=>true,'name'=>"Security Deposits",'notes'=>""]);
        //5. Account Payable
        $ac_payable->default_accounts()->create(['code'=>301,'sys_default'=>true,'name'=>"Accounts Payable (A/P)",'notes'=>""]);
        //6. Credit Card
        $credit_card->default_accounts()->create(['code'=>401,'sys_default'=>true,'name'=>"Credit card",'notes'=>""]);
        //7. Liability:Current liability
        $current_liability->default_accounts()->create(['code'=>501,'sys_default'=>true,'name'=>"Accrued liabilities",'notes'=>""]);
        //$current_liability->default_accounts()->create(['code'=>502,'sys_default'=>true,'name'=>"Client Trust Accounts - Liabilities"]);
        $current_liability->default_accounts()->create(['code'=>503,'sys_default'=>true,'name'=>"Current Tax Liability",'notes'=>""]);
        $current_liability->default_accounts()->create(['code'=>504,'sys_default'=>true,'name'=>"Current portion of obligations under finance leases",'notes'=>""]);
        $current_liability->default_accounts()->create(['code'=>505,'sys_default'=>true,'name'=>"Dividends payable",'notes'=>""]);
        $current_liability->default_accounts()->create(['code'=>506,'sys_default'=>true,'name'=>"Income tax payable",'notes'=>""]);
        $current_liability->default_accounts()->create(['code'=>507,'sys_default'=>true,'name'=>"Insurance payable",'notes'=>""]);
        $current_liability->default_accounts()->create(['code'=>508,'sys_default'=>true,'name'=>"Line of Credit",'notes'=>""]);
        $current_liability->default_accounts()->create(['code'=>509,'sys_default'=>true,'name'=>"Loan Payable",'notes'=>""]);
        $current_liability->default_accounts()->create(['code'=>510,'sys_default'=>true,'name'=>"Other current liabilities",'notes'=>""]);
        $current_liability->default_accounts()->create(['code'=>511,'sys_default'=>true,'name'=>"Payroll Clearing",'notes'=>""]);
        $current_liability->default_accounts()->create(['code'=>512,'sys_default'=>true,'name'=>"Payroll liabilities",'notes'=>""]);
        $current_liability->default_accounts()->create(['code'=>513,'sys_default'=>true,'name'=>"Prepaid Expenses Payable",'notes'=>""]);
        $current_liability->default_accounts()->create(['code'=>514,'sys_default'=>true,'name'=>"Rents in trust - Liability",'notes'=>""]);
        $current_liability->default_accounts()->create(['code'=>515,'sys_default'=>true,'name'=>"Sales and service tax payable",'notes'=>""]);
        $current_liability->default_accounts()->create(['code'=>516,'sys_default'=>true,'name'=>"Unearned Revenue",'notes'=>"A liability account that reports amounts received in advance of providing goods or services. When the goods or services are provided, this account balance is decreased and a revenue account is increased."]);
        //8. Lia
        $non_current_liability->default_accounts()->create(['code'=>517,'sys_default'=>true,'name'=>"Accrued holiday payable",'notes'=>""]);
        $non_current_liability->default_accounts()->create(['code'=>518,'sys_default'=>true,'name'=>"Accrued non-current liabilities",'notes'=>""]);
        $non_current_liability->default_accounts()->create(['code'=>519,'sys_default'=>true,'name'=>"Liabilities related to assets held for sale",'notes'=>""]);
        $non_current_liability->default_accounts()->create(['code'=>520,'sys_default'=>true,'name'=>"Long-term debt",'notes'=>""]);
        $non_current_liability->default_accounts()->create(['code'=>521,'sys_default'=>true,'name'=>"Notes Payable",'notes'=>""]);
        $non_current_liability->default_accounts()->create(['code'=>522,'sys_default'=>true,'name'=>"Other non-current liabilities",'notes'=>""]);
        $non_current_liability->default_accounts()->create(['code'=>523,'sys_default'=>true,'name'=>"Shareholder Notes Payable",'notes'=>""]);
        //9. Equity
        $owner_equity->default_accounts()->create(['code'=>601,'sys_default'=>true,'name'=>"Accumulated adjustment",'notes'=>""]);
        $owner_equity->default_accounts()->create(['code'=>602,'sys_default'=>true,'name'=>"Dividend disbursed",'notes'=>""]);
        $owner_equity->default_accounts()->create(['code'=>603,'sys_default'=>true,'name'=>"Equity in earnings of subsidiaries",'notes'=>""]);
        $owner_equity->default_accounts()->create(['code'=>604,'sys_default'=>true,'name'=>"Opening Balance Equity",'notes'=>"System creates this account the first time you enter an opening balance for a balance sheet account. As you enter opening balances, System records the amounts in 'Opening balance equity'. This ensures that you have a correct balance sheet for your company, even before you’ve finished entering all your company’s assets and liabilities."]);
        $owner_equity->default_accounts()->create(['code'=>605,'sys_default'=>true,'name'=>"Ordinary shares",'notes'=>""]);
        $owner_equity->default_accounts()->create(['code'=>606,'sys_default'=>true,'name'=>"Other comprehensive income",'notes'=>""]);
        $owner_equity->default_accounts()->create(['code'=>607,'sys_default'=>true,'name'=>"Owner's Equity",'notes'=>""]);
        $owner_equity->default_accounts()->create(['code'=>608,'sys_default'=>true,'name'=>"Paid-in capital or surplus",'notes'=>""]);
        $owner_equity->default_accounts()->create(['code'=>609,'sys_default'=>true,'name'=>"Partner Contributions",'notes'=>""]);
        $owner_equity->default_accounts()->create(['code'=>610,'sys_default'=>true,'name'=>"Partner Distributions",'notes'=>""]);
        $owner_equity->default_accounts()->create(['code'=>611,'sys_default'=>true,'name'=>"Partner's Equity",'notes'=>""]);
        $owner_equity->default_accounts()->create(['code'=>612,'sys_default'=>true,'name'=>"Preferred shares",'notes'=>""]);
        $owner_equity->default_accounts()->create(['code'=>613,'sys_default'=>true,'name'=>"Retained Earnings",'notes'=>""]);
        $owner_equity->default_accounts()->create(['code'=>614,'sys_default'=>true,'name'=>"Share capital",'notes'=>""]);
        $owner_equity->default_accounts()->create(['code'=>615,'sys_default'=>true,'name'=>"Treasury Shares",'notes'=>""]);
        //10. iNCOME
        //$income->default_accounts()->create(['code'=>901,'sys_default'=>true,'name'=>"Discounts/Refunds Given"]);
        $income->default_accounts()->create(['code'=>901,'sys_default'=>true,'name'=>"Discount Received",'notes'=>""]);
        $income->default_accounts()->create(['code'=>902,'sys_default'=>true,'name'=>"Non-Profit Income",'notes'=>""]);
        $income->default_accounts()->create(['code'=>903,'sys_default'=>true,'name'=>"Other Primary Income",'notes'=>""]);
        $income->default_accounts()->create(['code'=>904,'sys_default'=>true,'name'=>"Revenue - General",'notes'=>""]);
        $income->default_accounts()->create(['code'=>905,'sys_default'=>true,'name'=>"Sales - retail",'notes'=>""]);
        $income->default_accounts()->create(['code'=>906,'sys_default'=>true,'name'=>"Sales",'notes'=>""]);
        $income->default_accounts()->create(['code'=>907,'sys_default'=>true,'name'=>"Sales - wholesale",'notes'=>""]);
        $income->default_accounts()->create(['code'=>908,'sys_default'=>true,'name'=>"Sales of Product Income",'notes'=>""]);
        $income->default_accounts()->create(['code'=>909,'sys_default'=>true,'name'=>"Service/Fee Income",'notes'=>""]);
        $income->default_accounts()->create(['code'=>910,'sys_default'=>true,'name'=>"Unapplied Cash Payment Income",'notes'=>""]);
        //Other Incomes
        $other_income->default_accounts()->create(['code'=>921,'sys_default'=>true,'name'=>"Dividend income",'notes'=>""]);
        $other_income->default_accounts()->create(['code'=>922,'sys_default'=>true,'name'=>"Interest earned",'notes'=>""]);
        $other_income->default_accounts()->create(['code'=>923,'sys_default'=>true,'name'=>"Loss on disposal of assets",'notes'=>""]);
        $other_income->default_accounts()->create(['code'=>924,'sys_default'=>true,'name'=>"Other Investment Income",'notes'=>""]);
        $other_income->default_accounts()->create(['code'=>925,'sys_default'=>true,'name'=>"Other Miscellaneous Income",'notes'=>""]);
        $other_income->default_accounts()->create(['code'=>926,'sys_default'=>true,'name'=>"Other operating income",'notes'=>""]);
        $other_income->default_accounts()->create(['code'=>927,'sys_default'=>true,'name'=>"Tax-Exempt Interest",'notes'=>""]);
        $other_income->default_accounts()->create(['code'=>928,'sys_default'=>true,'name'=>"Unrealised loss on securities, net of tax",'notes'=>""]);
        //Expenses: COS(Cost of Sale)
        $cost_of_sale->default_accounts()->create(['code'=>1001,'sys_default'=>true,'name'=>"Cost of labour - COS",'notes'=>""]);
        $cost_of_sale->default_accounts()->create(['code'=>1002,'sys_default'=>true,'name'=>"Equipment rental - COS",'notes'=>""]);
        $cost_of_sale->default_accounts()->create(['code'=>1003,'sys_default'=>true,'name'=>"Freight and delivery - COS",'notes'=>""]);
        $cost_of_sale->default_accounts()->create(['code'=>1004,'sys_default'=>true,'name'=>"Costs of sales",'notes'=>""]);
        $cost_of_sale->default_accounts()->create(['code'=>1005,'sys_default'=>true,'name'=>"Other costs of sales - COS",'notes'=>""]);
        $cost_of_sale->default_accounts()->create(['code'=>1006,'sys_default'=>true,'name'=>"Supplies and materials - COS",'notes'=>""]);
        //Expenses:
        $expenses->default_accounts()->create(['code'=>1101,'sys_default'=>true,'name'=>"Advertising/Promotional",'notes'=>""]);
        $expenses->default_accounts()->create(['code'=>1102,'sys_default'=>true,'name'=>"Amortisation expense",'notes'=>""]);
        $expenses->default_accounts()->create(['code'=>1103,'sys_default'=>true,'name'=>"Auto",'notes'=>""]);
        $expenses->default_accounts()->create(['code'=>1104,'sys_default'=>true,'name'=>"Bad debts",'notes'=>""]);
        $expenses->default_accounts()->create(['code'=>1105,'sys_default'=>true,'name'=>"Bank charges",'notes'=>""]);
        $expenses->default_accounts()->create(['code'=>1106,'sys_default'=>true,'name'=>"Charitable Contributions",'notes'=>""]);
        $expenses->default_accounts()->create(['code'=>1107,'sys_default'=>true,'name'=>"Commissions and fees",'notes'=>""]);
        $expenses->default_accounts()->create(['code'=>1108,'sys_default'=>true,'name'=>"Cost of Labour",'notes'=>""]);
        $expenses->default_accounts()->create(['code'=>1109,'sys_default'=>true,'name'=>"Dues and Subscriptions",'notes'=>""]);
        $expenses->default_accounts()->create(['code'=>1110,'sys_default'=>true,'name'=>"Equipment rental",'notes'=>""]);
        $expenses->default_accounts()->create(['code'=>1111,'sys_default'=>true,'name'=>"Finance costs",'notes'=>""]);
        $expenses->default_accounts()->create(['code'=>1112,'sys_default'=>true,'name'=>"Income tax expense",'notes'=>""]);
        $expenses->default_accounts()->create(['code'=>1113,'sys_default'=>true,'name'=>"Insurance",'notes'=>""]);
        $expenses->default_accounts()->create(['code'=>1114,'sys_default'=>true,'name'=>"Interest paid",'notes'=>""]);
        $expenses->default_accounts()->create(['code'=>1115,'sys_default'=>true,'name'=>"Legal and professional fees",'notes'=>""]);
        $expenses->default_accounts()->create(['code'=>1116,'sys_default'=>true,'name'=>"Loss on discontinued operations, net of tax",'notes'=>""]);
        $expenses->default_accounts()->create(['code'=>1117,'sys_default'=>true,'name'=>"Management compensation",'notes'=>""]);
        $expenses->default_accounts()->create(['code'=>1118,'sys_default'=>true,'name'=>"Meals and entertainment",'notes'=>""]);
        $expenses->default_accounts()->create(['code'=>1119,'sys_default'=>true,'name'=>"Office/General Administrative Expenses",'notes'=>""]);
        $expenses->default_accounts()->create(['code'=>1120,'sys_default'=>true,'name'=>"Other Miscellaneous Service Cost",'notes'=>""]);
        $expenses->default_accounts()->create(['code'=>1121,'sys_default'=>true,'name'=>"Other selling expenses",'notes'=>""]);
        $expenses->default_accounts()->create(['code'=>1122,'sys_default'=>true,'name'=>"Payroll Expense",'notes'=>""]);
        $expenses->default_accounts()->create(['code'=>1123,'sys_default'=>true,'name'=>"Rent or Lease of Buildings",'notes'=>""]);
        $expenses->default_accounts()->create(['code'=>1124,'sys_default'=>true,'name'=>"Repair and maintenance",'notes'=>""]);
        $expenses->default_accounts()->create(['code'=>1125,'sys_default'=>true,'name'=>"Shipping and delivery expense",'notes'=>""]);
        $expenses->default_accounts()->create(['code'=>1126,'sys_default'=>true,'name'=>"Supplies and materials",'notes'=>""]);
        $expenses->default_accounts()->create(['code'=>1127,'sys_default'=>true,'name'=>"Taxes paid",'notes'=>""]);
        $expenses->default_accounts()->create(['code'=>1128,'sys_default'=>true,'name'=>"Travel expenses - general and admin expenses",'notes'=>""]);
        $expenses->default_accounts()->create(['code'=>1129,'sys_default'=>true,'name'=>"Travel expenses - selling expense",'notes'=>""]);
        $expenses->default_accounts()->create(['code'=>1130,'sys_default'=>true,'name'=>"Unapplied Cash Bill Payment Expense",'notes'=>""]);
        $expenses->default_accounts()->create(['code'=>1131,'sys_default'=>true,'name'=>"Utilities",'notes'=>""]);
        //$expenses->default_accounts()->create(['code'=>1132,'sys_default'=>true,'name'=>""]);
        //Other Expenses
        $other_expense->default_accounts()->create(['code'=>1201,'sys_default'=>true,'name'=>"Discount Allowed",'notes'=>""]);
        $other_expense->default_accounts()->create(['code'=>1202,'sys_default'=>true,'name'=>"Depreciation",'notes'=>""]);
        $other_expense->default_accounts()->create(['code'=>1203,'sys_default'=>true,'name'=>"Exchange Gain or Loss",'notes'=>""]);
        $other_expense->default_accounts()->create(['code'=>1204,'sys_default'=>true,'name'=>"Other Expense",'notes'=>""]);
        $other_expense->default_accounts()->create(['code'=>1205,'sys_default'=>true,'name'=>"Penalties and settlements",'notes'=>""]);
        $other_expense->default_accounts()->create(['code'=>1206,'sys_default'=>true,'name'=>"Amortisation",'notes'=>""]);
        //END==============================================================


        $accountingRepository = new AccountingRepository(new AccountsCoa());
        $coas = AccountsCoa::all();
        $facilities = Practice::all();
        $hospital = Hospital::find(1);
        foreach ($facilities as $facility) {

            foreach ($coas as $coa) {
                //Create company's COA in AccountsCOA
                $inputs['name'] = $coa->name;
                $inputs['code'] = $coa->code.'0000'.$facility->id;
                $inputs['accounts_type_id'] = $coa->accounts_type_id;
                $inputs['sys_default'] = true;
                $inputs['is_special'] = false;
                //Create account in itself
                $default_account = AccountsCoa::create($inputs);
                //Link above account to a company
                $default_account = $facility->coas()->save($default_account);
                $inputs2['name'] = $coa->name;
                $inputs2['code'] = $coa->code.'0000'.$facility->id;
                $inputs2['accounts_type_id'] = $coa->accounts_type_id;
                $inputs2['default_code'] = $coa->code; //This default_code links this account to "System Default COA"
                $inputs2['is_special'] = true;
                //Create this company default&special account in debitable,creditable table
                $debitable_creditable_ac = $default_account->chart_of_accounts()->create($inputs2);//This also links it to parent default account
                //Link above debitable_creditable_ac account to a company
                $debitable_creditable_ac = $facility->chart_of_accounts()->save($debitable_creditable_ac);

                //If account is Tax Payable configure Company Sales Tax Accounts
                if( $coa->code == AccountsCoa::AC_SALES_SERVICE_TAX_PAYABLE_CODE ){
                    //Get taxation from main branch
                    $taxations = ProductTaxation::all();
                    foreach( $taxations as $taxation ){
                        //Attach to branch
                        $practice_taxation = $taxation->practice_taxation()->create(['practice_id'=>$facility->id]);
                        //Use Branch Taxation to create Tax Chart of Account
                        $sub_ac_inputs['name'] = $taxation->name;
                        $tax_sub_accounts = $accountingRepository->create_sub_chart_of_account($facility,$debitable_creditable_ac,$sub_ac_inputs,$practice_taxation);
                    }
                }
            }
            //Customer Terms
            $facility->customer_terms()->create(['name'=>'net 15','notes'=>'full payment is expected within 10 days']);
            $facility->customer_terms()->create(['name'=>'net 30','notes'=>'full payment is expected within 30 days']);
            $facility->customer_terms()->create(['name'=>'net 45','notes'=>'full payment is expected within 45 days']);
            $facility->customer_terms()->create(['name'=>'net 60','notes'=>'full payment is expected within 60 days']);
            $facility->customer_terms()->create(['name'=>'2% 10, net 30','notes'=>"2% discount can be taken by the buyer only if payment is received in full within 10 days of the date of the invoice, and that full payment is expected within 30 days"]);
            $facility->customer_terms()->create(['name'=>'Due on Receipt','notes'=>"You're expected to be pay as soon as possible after you receive the invoice"]);
            $facility->customer_terms()->create(['name'=>'Due end of the month','notes'=>'full payment is expected end month']);
            $facility->customer_terms()->create(['name'=>'Due end of next month','notes'=>'full payment is expected end of next month']);
            //supplier_terms
            $facility->supplier_terms()->create(['name'=>'net 15','notes'=>'full payment is expected within 10 days']);
            $facility->supplier_terms()->create(['name'=>'net 30','notes'=>'full payment is expected within 30 days']);
            $facility->supplier_terms()->create(['name'=>'net 45','notes'=>'full payment is expected within 45 days']);
            $facility->supplier_terms()->create(['name'=>'net 60','notes'=>'full payment is expected within 60 days']);
            $facility->supplier_terms()->create(['name'=>'2% 10, net 30','notes'=>"2% discount can be taken by the buyer only if payment is received in full within 10 days of the date of the invoice, and that full payment is expected within 30 days"]);
            $facility->supplier_terms()->create(['name'=>'Due on Receipt','notes'=>"You're expected to be pay as soon as possible after you receive the invoice"]);
            $facility->supplier_terms()->create(['name'=>'Due end of the month','notes'=>'full payment is expected end month']);
            $facility->supplier_terms()->create(['name'=>'Due end of next month','notes'=>'full payment is expected end of next month']);
            //Payment Types
            $facility->accounts_payment_methods()->create(['name'=>'Cash']);
            $facility->accounts_payment_methods()->create(['name'=>'Cheque']);
            $facility->accounts_payment_methods()->create(['name'=>'Credit Card']);
            $facility->accounts_payment_methods()->create(['name'=>'Direct Debit']);
            //
        }



        

    }
}

/*
    Use "Sales and service tax payable" to track tax you have collected, 
    but not yet remitted to your government tax agency. 
    This includes value-added tax, goods and services tax, 
    sales tax, and other consumption tax.
*/

/*
    Use "Income tax payable" to track monies that are due to pay
     the company’s income tax liabilties.
*/

/*
    Use "Current tax liability" to track the total amount 
    of taxes collected but not yet paid to the government.
*/
